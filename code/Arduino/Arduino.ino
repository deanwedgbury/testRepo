// Power pump based on DHT humidity/temperature sensors and (YL-69 + YL-39) mositure sensor
// February 2017

#include "DHT.h"
#include <Wire.h>

//communcation with pi
#define SLAVE_ADDRESS 0x04
int received = -1;
int dataToSend;

//DHT sensor stuff
#define DHTPIN 12     //sensor pin
#define DHTTYPE DHT11   // DHT 11 
DHT dht(DHTPIN, DHTTYPE);
float humidity;
float temp;

//moisture
int soilPin = A0;//Declare a variable for the soil moisture sensor 
int soilPower = 7;//Variable for Soil moisture Power
int moisture; //0-92 is wet, 93-150 is humid, 150-250 is dry, 250-255 is in air

//pump
int motorState = 0;
int motorControllerPin = 7;
int motorPin = 6;


void setup() {
  Serial.begin(9600); // start serial for output

  //rpi
  pinMode(13, OUTPUT);
  // initialize i2c as slave
  Wire.begin(SLAVE_ADDRESS);
  
  // define callbacks for i2c communication
  Wire.onReceive(receiveData);
  Wire.onRequest(sendData);
  
  Serial.println("Ready!");


  //DHT stuff
  dht.begin();

  //moisture
  pinMode(soilPin, INPUT);
}

void loop() {
  digitalWrite(motorControllerPin, HIGH);
  
  delay(1000);

  //DHT
  // Reading temperature or humidity takes about 90 milliseconds!
  // Sensor readings may also be up to 2 seconds 'old' (its a very slow sensor)
  humidity = dht.readHumidity(); // Read humidity
  temp = dht.readTemperature(); // Read temperature as Celsius
  
  // Check if any reads failed and exit early (to try again).
  if (isnan(humidity) || isnan(temp)) {
    Serial.println("Failed to read from DHT sensor!");
  }

  //moisture
  moisture = map(analogRead(A0), 0, 1023, 0, 255); //turn input from 0-1023 to 0-255
  if (isnan(moisture)) {
    Serial.println("Failed to read from moisture sensor!");
  }

  Serial.print("Temp: ");
  Serial.print((int)temp);
  Serial.print(" Hum: ");
  Serial.print((int)humidity);
  Serial.print(" Moisture: ");
  Serial.print(moisture);
  Serial.print("\n");
  
}

// callback for received data
void receiveData(int byteCount){

  while(Wire.available()) {
    received = Wire.read();
    Serial.print("data received: ");
    Serial.println(received);

    switch (received){
      case 1: //temp
        dataToSend = temp;
        break;
        
      case 2: //humidity
        dataToSend = humidity;
        break;

      case 3: //moisture
        dataToSend = moisture;
        break;

      case 9: //toggle led
      
        if (motorState == 0){
          digitalWrite(13, HIGH); // set the LED on
          digitalWrite(motorPin, HIGH);
          motorState = 1;
        } else{
          digitalWrite(13, LOW); // set the LED off
          digitalWrite(motorPin, LOW);
          motorState = 0;
        }
        dataToSend = motorState;
        break;
        
    } //end switch
  
  }
}

// callback for sending data
void sendData(){
  Wire.write(dataToSend);
}
