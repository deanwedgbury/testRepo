// Power pump based on DHT humidity/temperature sensors and (YL-69 + YL-39) mositure sensor
// February 2017

#include "DHT.h"
#include <FastIO.h>
#include <I2CIO.h>
#include <LCD.h>
#include <LiquidCrystal.h>
#include <LiquidCrystal_I2C.h>
#include <LiquidCrystal_SR.h>
#include <LiquidCrystal_SR2W.h>
#include <LiquidCrystal_SR3W.h>
#include <Wire.h>

#define DHTPIN 12     //sensor pin
#define DHTTYPE DHT11   // DHT 11 

DHT dht(DHTPIN, DHTTYPE);

LiquidCrystal_I2C lcd(0x27, 2, 1, 0, 4, 5, 6, 7, 3, POSITIVE);

int val = 0; //value for storing moisture value 
int soilPin = A0;//Declare a variable for the soil moisture sensor 
int soilPower = 7;//Variable for Soil moisture Power

int pumpPin = 8; //when HIGH, pump activates

void setup() {
  Serial.begin(9600); 
  dht.begin();
  lcd.begin(16,2);

  pinMode(soilPin, INPUT);
  pinMode(pumpPin,OUTPUT);
}

void loop() {
  
  //delay(1000); 
  
  // Reading temperature or humidity takes about 90 milliseconds!
  // Sensor readings may also be up to 2 seconds 'old' (its a very slow sensor)
  float h = dht.readHumidity(); // Read humidity
  float t = dht.readTemperature(); // Read temperature as Celsius
  float f = dht.readTemperature(true); // Read temperature as Fahrenheit
  
  // Check if any reads failed and exit early (to try again).
  if (isnan(h) || isnan(t)) {
    Serial.println("Failed to read from DHT sensor!");
    return;
  }

  // Compute heat index
  // Must send in temp in Fahrenheit!
  float hi = dht.computeHeatIndex(f, h);

  Serial.print("x");
  Serial.print((int)t);
  Serial.print("y");
  Serial.print("\n");
  
  lcd.setCursor(0,0);
  lcd.print("Tem:");
  lcd.print((int)t);
  lcd.print((char)223); //degree symbol
  lcd.print("C ");
  
  lcd.print("Hum:");
  lcd.print((int)h);
  lcd.print("%");

  int SensorValue = analogRead(A0); //take a sample
  Serial.print(SensorValue); Serial.print(" - ");

  lcd.setCursor(0,1);
  //lcd.print(SensorValue);
  if(SensorValue >= 1000) {
   Serial.println("Sensor is not in the Soil or DISCONNECTED");
   lcd.print("Sensor in AIR   ");
   digitalWrite(pumpPin, LOW);
  }
  if(SensorValue < 1000 && SensorValue >= 600) { 
   Serial.println("Soil is DRY");
   lcd.print("Soil is DRY    ");
   digitalWrite(pumpPin, HIGH);
  }
  if(SensorValue < 600 && SensorValue >= 370) {
   Serial.println("Soil is HUMID"); 
   lcd.print("Soil is HUMID     ");
   digitalWrite(pumpPin, LOW);
  }
  if(SensorValue < 370) {
   Serial.println("Sensor in WATER");
   lcd.print("Sensor in WATER  ");
   digitalWrite(pumpPin, LOW);
  }
    
}//end loop
