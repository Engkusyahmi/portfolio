#include <WiFi.h>
#include <HTTPClient.h>

// --- WIFI CONFIGURATION ---
const char* ssid = "engkusyahmi";
const char* password = "syahmi0904";

// --- PIN & SENSOR CONFIGURATION ---
const int sensorPin = 4;   // Pin D4 (Water Flow Sensor)
const int pumpPin = 33;    // Pin D33 (Water Pump Relay/Transistor)

// --- DATA VARIABLES ---
volatile int pulseCount = 0;
float flowRate = 0.0;
float totalConsumption = 0.0;
unsigned long oldTime = 0;

// Interrupt Service Routine (ISR) for sensor pulse counting
void IRAM_ATTR pulseCounter() {
  pulseCount++;
}

void setup() {
  Serial.begin(115200);

  // Initialize I/O Pins and Interrupts
  pinMode(sensorPin, INPUT_PULLUP);
  attachInterrupt(digitalPinToInterrupt(sensorPin), pulseCounter, FALLING);
  
  pinMode(pumpPin, OUTPUT);
  digitalWrite(pumpPin, HIGH); // Turn on water pump immediately at startup
  Serial.println("System Started: Pump ON");

  // Connect to WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi Connected");
}

void loop() {
  // Process sensor data every 10 seconds (10000 ms)
  if ((millis() - oldTime) > 10000) {
    
    // Detach interrupt during calculations to ensure data integrity
    detachInterrupt(digitalPinToInterrupt(sensorPin));
    
    // Calculate Flow Rate (L/min) & Total Liters (For YF-S201 sensor)
    flowRate = ((1000.0 / (millis() - oldTime)) * pulseCount) / 7.5;
    oldTime = millis();
    totalConsumption += (flowRate / 60.0) * 10; // 10-second accumulation
    
    // Reset pulse count and re-attach interrupt
    pulseCount = 0;
    attachInterrupt(digitalPinToInterrupt(sensorPin), pulseCounter, FALLING);

    // Print data to Serial Monitor (Formatted to 2 decimal places)
    Serial.printf("Flow rate: %.2f L/min | Total: %.2f L\n", flowRate, totalConsumption);

    // Send data to API Database
    if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;
      http.begin("https://078730.unisza.work/webapp/api/insert_sensor.php");
      http.addHeader("Content-Type", "application/json");

      // Construct JSON payload
      String jsonData = "{\"device_id\":\"ESP-WASH-01\",\"flow_rate\":" + String(flowRate) + 
                        ",\"total_consumption\":" + String(totalConsumption) + "}";

      int responseCode = http.POST(jsonData);
      Serial.printf("HTTP Response: %d\n", responseCode);

      http.end();
    } else {
      Serial.println("WiFi Disconnected! Failed to send data.");
    }
  }
}