#include <OneWire.h>
#include <DallasTemperature.h>

// 🧠 Define the GPIO pin you connected the DS18B20 DATA line to
#define ONE_WIRE_BUS 4  // Change this if you used a different pin

// 🧱 Create instances for OneWire and DallasTemperature
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);

void setup() {
  Serial.begin(115200);
  sensors.begin();
  Serial.println("📡 DS18B20 Temperature Sensor Initialized...");
}

void loop() {
  sensors.requestTemperatures(); // 🔁 Ask for temperature from sensor
  float tempC = sensors.getTempCByIndex(0); // 📈 Get temperature in Celsius

  Serial.print("🌡️ Current Temperature: ");
  Serial.print(tempC);
  Serial.println(" °C");

  // 🚨 Warning system for temperature levels
  if (tempC < 10) {
    Serial.println("❄️ WARNING: Too COLD for most plants/fish!");
  } else if (tempC > 30) {
    Serial.println("🔥 WARNING: Too HOT for most plants/fish!");
  } else if (tempC < 18 || tempC > 28) {
    Serial.println("⚠️ NOTICE: Temperature is outside the IDEAL range, but still acceptable.");
  } else {
    Serial.println("✅ Temperature is in the NORMAL range.");
  }

  Serial.println("------------------------------------------------");
  delay(2000); // ⏱️ Delay for 2 seconds before next read
}
