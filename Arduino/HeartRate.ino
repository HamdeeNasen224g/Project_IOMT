#include <MAX30100.h>

#include <Wire.h>
#include "MAX30105.h"
#include <LiquidCrystal_PCF8574.h>
#include "heartRate.h"

MAX30105 particleSensor;

 LiquidCrystal_PCF8574 lcd(0x3F); // set the LCD address to 0x27 for a 16 chars and 2 line display

const byte RATE_SIZE = 4; //Increase this for more averaging. 4 is good.
byte rates[RATE_SIZE]; //Array of heart rates
byte rateSpot = 0;
long lastBeat = 0; //Time at which the last beat occurred
 
float beatsPerMinute;
int beatAvg;
void checkAddress(){
  // Leonardo: wait for serial port to connect
  while (!Serial)
  {
  }
  Serial.println ();
  Serial.println ("I2C scanner. Scanning ...");
  byte count = 0;
  for (byte i = 8; i < 120; i++)
  {
    Wire.beginTransmission (i);
    if (Wire.endTransmission () == 0)
    {
      Serial.print ("Found address: ");
      Serial.print (i, DEC);
      Serial.print (" (0x");
      Serial.print (i, HEX);
      Serial.println (")");
      count++;
      delay (1); // maybe unneeded?
    } // end of good response
  } // end of for loop
  Serial.println ("Done.");
  Serial.print ("Found ");
  Serial.print (count, DEC);
  Serial.println (" device(s).");
  
  };

void setup()
{
Serial.begin(115200);  
Wire.begin(); 
lcd.setBacklight(255);
 lcd.begin(16,2);  
    lcd.print("Initializing...");
    delay(3600);
    lcd.clear();  
checkAddress();

Serial.println("Initializing...");
 
// Initialize sensor
if (!particleSensor.begin(Wire, I2C_SPEED_FAST)) //Use default I2C port, 400kHz speed
{
Serial.println("MAX30105 was not found. Please check wiring/power. ");
while (1);
}
Serial.println("Place your index finger on the sensor with steady pressure.");
 
particleSensor.setup(); //Configure sensor with default settings
particleSensor.setPulseAmplitudeRed(0x0A); //Turn Red LED to low to indicate sensor is running
particleSensor.setPulseAmplitudeGreen(0); //Turn off Green LED
}
 
void loop()
{
long irValue = particleSensor.getIR();
 
if (checkForBeat(irValue) == true)
{
//We sensed a beat!
long delta = millis() - lastBeat;
lastBeat = millis();
 
beatsPerMinute = 60 / (delta / 1000.0);
 
if (beatsPerMinute < 255 && beatsPerMinute > 20)
{
rates[rateSpot++] = (byte)beatsPerMinute; //Store this reading in the array
rateSpot %= RATE_SIZE; //Wrap variable
 
//Take average of readings
beatAvg = 0;
for (byte x = 0 ; x < RATE_SIZE ; x++)
beatAvg += rates[x];
beatAvg /= RATE_SIZE;
}
}
 
Serial.print("IR=");
Serial.print(irValue);
Serial.print(", BPM=");
Serial.print(beatsPerMinute);
Serial.print(", Avg BPM=");
Serial.print(beatAvg);
 
if (irValue < 50000)
Serial.print(" No finger?");
 
Serial.println();
}
