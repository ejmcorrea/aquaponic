#include <OneWire.h>
#include <DallasTemperature.h>

// Pin Definitions
const int tdsPin = 34;          // TDS sensor pin (A0)
const int turbidityPin = 35;    // Turbidity sensor on another analog pin
#define ONE_WIRE_BUS 4          // DS18B20 waterproof temperature sensor

// Constants
const float vRef = 3.3;
const int adcResolution = 4095;

// OneWire & Dallas Temperature setup
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

void setup() {
  Serial.begin(115200);
  analogReadResolution(12);

  sensors.begin();

  Serial.println("🔧 All Sensors Initialized...");
}

void loop() {
  // ---------- DS18B20 Temperature Sensor ----------
  sensors.requestTemperatures();
  float tempC = sensors.getTempCByIndex(0);

  Serial.print("🌡️ Temperature: ");
  Serial.print(tempC);
  Serial.println(" °C");

  if (tempC < 10) {
    Serial.println("❄️ Too COLD for most plants/fish!");
  } else if (tempC > 30) {
    Serial.println("🔥 Too HOT for most plants/fish!");
  } else if (tempC < 18 || tempC > 28) {
    Serial.println("⚠️ Outside IDEAL range.");
  } else {
    Serial.println("✅ Temperature is NORMAL.");
  }

  Serial.println("------------------------------------------------");

  // ---------- Turbidity Sensor ----------
  int turbidityRaw = analogRead(turbidityPin);
  float turbidityVoltage = turbidityRaw * (5.0 / 4095.0);
  float ntu = 100.0 - (turbidityVoltage * 100.0);
  if (ntu < 0) ntu = 0;

  Serial.print("🌫️ Turbidity Voltage: ");
  Serial.print(turbidityVoltage, 2);
  Serial.print(" V | NTU: ");
  Serial.print(ntu, 2);
  Serial.print(" --> ");
  Serial.println(ntu > 50.0 ? "Cloudy" : "Clear");

  Serial.println("------------------------------------------------");

  // ---------- TDS Sensor ----------
  int tdsRaw = analogRead(tdsPin);
  float tdsVoltage = tdsRaw * vRef / adcResolution;
  float tdsValue = (133.42 * pow(tdsVoltage, 3)
                   - 255.86 * pow(tdsVoltage, 2)
                   + 857.39 * tdsVoltage) * 0.5;

  Serial.print("💧 TDS Raw: ");
  Serial.print(tdsRaw);
  Serial.print(" | Voltage: ");
  Serial.print(tdsVoltage, 2);
  Serial.print(" V | TDS: ");
  Serial.print(tdsValue, 2);
  Serial.print(" ppm --> ");

  if (tdsValue < 200) {
    Serial.println("❌ Too Low");
  } else if (tdsValue < 400) {
    Serial.println("⚠️ Low but Acceptable");
  } else if (tdsValue <= 800) {
    Serial.println("✅ Ideal");
  } else if (tdsValue <= 1200) {
    Serial.println("⚠️ High – Monitor");
  } else {
    Serial.println("❌ Too High");
  }

  Serial.println("================================================");
  delay(2000);  // Wait 2 seconds before the next cycle
}
