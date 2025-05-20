#include <WiFi.h>
#include <HTTPClient.h>
#include <OneWire.h>
#include <DallasTemperature.h>

// WiFi credentials
const char* ssid = "Josh";             
const char* password = "mazi9839";     

// Sensor pins
const int tdsPin = 34;
const int turbidityPin = 35;
#define ONE_WIRE_BUS 4
const int DO_PIN = 32;  // DO sensor
const int pH_pin = 33;  // pH sensor (new)

// Constants
const float vRef = 3.3; 
const int adcResolution = 4095;

// DO Calibration
const float V_AIR = 1.397;
const float V_ZERO = 0.074;

// pH Calibration
const float slope = -35.42;
const float intercept = 112.3;

// OneWire & DS18B20 setup
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

float getAverageVoltage(int pin, int samples = 20) {
  long sum = 0;
  for (int i = 0; i < samples; i++) {
    sum += analogRead(pin);
    delay(10);
  }
  float avgADC = sum / (float)samples;
  return avgADC * (vRef / adcResolution);
}

void setup() {
  Serial.begin(57600);
  analogReadResolution(12);
  sensors.begin();

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  Serial.print("\xF0\x9F\x94\x8C Connecting to WiFi");
  int attempts = 0;
  while (WiFi.status() != WL_CONNECTED && attempts < 40) {
    delay(500);
    Serial.print(".");
    attempts++;
  }

  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("\n\xE2\x9C\x85 WiFi Connected!");
    Serial.print("\xF0\x9F\x93\xB6 IP Address: ");
    Serial.println(WiFi.localIP());
  } else {
    Serial.println("\n\xE2\x9D\x8C WiFi Connection Failed.");
  }
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("\xE2\x9A\xA0\xEF\xB8\x8F Lost connection. Reconnecting...");
    WiFi.reconnect();
    delay(1000);
    return;
  }

  // Temperature
  sensors.requestTemperatures();
  float tempC = sensors.getTempCByIndex(0);

  // Turbidity
  int turbidityRaw = analogRead(turbidityPin);
  float turbidityVoltage = turbidityRaw * (vRef / adcResolution);
  float ntu = 100.0 - (turbidityVoltage * 100.0);
  if (ntu < 0) ntu = 0;

  // TDS
  int tdsRaw = analogRead(tdsPin);
  float tdsVoltage = tdsRaw * vRef / adcResolution;
  float tdsValue = (133.42 * pow(tdsVoltage, 3)
                   - 255.86 * pow(tdsVoltage, 2)
                   + 857.39 * tdsVoltage) * 0.5;

  // DO
  int doRaw = analogRead(DO_PIN);
  float doVoltage = doRaw * vRef / adcResolution;
  float do_mg_L = (doVoltage - V_ZERO) * 20.9 / (V_AIR - V_ZERO);
  do_mg_L = constrain(do_mg_L, 0.0, 20.9);

  // pH
  float pH_voltage = getAverageVoltage(pH_pin);
  float pH_value = slope * pH_voltage + intercept;

  // Debug prints
  Serial.print("\xF0\x9F\x8C\xA1 Temp: "); Serial.print(tempC, 2);
  Serial.print("\xC2\xB0C | \xF0\x9F\xA7\xAA Turbidity: "); Serial.print(ntu, 2);
  Serial.print(" NTU | \xF0\x9F\x92\x87 TDS: "); Serial.print(tdsValue, 2);
  Serial.print(" ppm | \xF0\x9F\xAB\xA7 DO: "); Serial.print(do_mg_L, 2);
  Serial.print(" mg/L | pH: "); Serial.println(pH_value, 2);

  // Send to server
  HTTPClient http;
  String serverPath = "http://192.168.18.167/submit_data.php?temperature=" + String(tempC, 2)
                    + "&turbidity=" + String(ntu, 2)
                    + "&tds=" + String(tdsValue, 2)
                    + "&dissolveoxygen=" + String(do_mg_L, 2)
                    + "&ph=" + String(pH_value, 2);

  http.begin(serverPath.c_str());
  int httpResponseCode = http.GET();

  if (httpResponseCode > 0) {
    String response = http.getString();
    Serial.println("\xF0\x9F\x93\xA1 Server Response: " + response);
  } else {
    Serial.print("\xE2\x9D\x8C HTTP Error: ");
    Serial.println(httpResponseCode);
  }

  http.end();
  delay(5000);
}