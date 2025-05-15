#include <WiFi.h>
#include <HTTPClient.h>
#include <OneWire.h>
#include <DallasTemperature.h>

// WiFi credentials
const char* ssid = "ASY";             // Must be 2.4GHz WiFi
const char* password = "ysabela18";   // Avoid special characters during testing

// Sensor pins
const int tdsPin = 34;
const int turbidityPin = 35;
#define ONE_WIRE_BUS 4

// Constants
const float vRef = 3.3; 
const int adcResolution = 4095;

// OneWire & DS18B20 setup
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

void setup() {
  Serial.begin(57600);
  analogReadResolution(12);
  sensors.begin();

  WiFi.mode(WIFI_STA); // Ensure it's in station mode
  WiFi.begin(ssid, password);

  Serial.print("🔌 Connecting to WiFi");
  int attempts = 0;

  // Try for 20 seconds (20 x 500ms)
  while (WiFi.status() != WL_CONNECTED && attempts < 40) {
    delay(500);
    Serial.print(".");
    attempts++;
  }

  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("\n✅ WiFi Connected!");
    Serial.print("📶 IP Address: ");
    Serial.println(WiFi.localIP());
  } else {
    Serial.println("\n❌ WiFi Connection Failed. Check SSID/password or use 2.4GHz.");
  }
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("⚠️ Lost connection. Reconnecting...");
    WiFi.reconnect();
    delay(1000);
    return;
  }

  // Get temperature
  sensors.requestTemperatures();
  float tempC = sensors.getTempCByIndex(0);

  // Turbidity
  int turbidityRaw = analogRead(turbidityPin);
  float turbidityVoltage = turbidityRaw * (5.0 / adcResolution);
  float ntu = 100.0 - (turbidityVoltage * 100.0);
  if (ntu < 0) ntu = 0;

  // TDS
  int tdsRaw = analogRead(tdsPin);
  float tdsVoltage = tdsRaw * vRef / adcResolution;
  float tdsValue = (133.42 * pow(tdsVoltage, 3)
                   - 255.86 * pow(tdsVoltage, 2)
                   + 857.39 * tdsVoltage) * 0.5;

  // Send to server
  HTTPClient http;
  String serverPath = "http://172.20.10.2/submit_data.php?temperature=" + String(tempC, 2)
                    + "&turbidity=" + String(ntu, 2)
                    + "&tds=" + String(tdsValue, 2);

  http.begin(serverPath.c_str());
  int httpResponseCode = http.GET();

  if (httpResponseCode > 0) {
    String response = http.getString();
    Serial.println("📡 Server Response: " + response);
  } else {
    Serial.print("❌ HTTP Error: ");
    Serial.println(httpResponseCode);
  }

  http.end();
  delay(5000);
}
