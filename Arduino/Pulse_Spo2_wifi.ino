#include <Wire.h>
#include <Adafruit_MLX90614.h>
#include "MAX30105.h"
#include "heartRate.h"
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

#define USEFIFO
MAX30105 particleSensor;
WiFiClient client;
#include <Ticker.h>

Ticker blinker;

String thingSpeakAddress= "http://api.thingspeak.com/update?";
String writeAPIKey;
String tsfield1Name;
String request_string;
String api_key = "EY4O6UXAM0DI1HEA";
HTTPClient http;


const byte RATE_SIZE = 4; //Increase this for more averaging. 4 is good.
byte rates[RATE_SIZE]; //Array of heart rates
byte rateSpot = 0;
long lastBeat = 0; //Time at which the last beat occurred
float beatsPerMinute;
int beatAvg;
int i = 0;
Adafruit_MLX90614 mlx = Adafruit_MLX90614();

double ESpO2 = 95.0;//initial value of estimated SpO2
double FSpO2 = 0.7; //filter factor for estimated SpO2
double frate = 0.95; //low pass filter for IR/red LED value to eliminate AC component
#define TIMETOBOOT 3000 // wait for this time(msec) to output SpO2
#define SCALE 88.0 //adjust to display heart beat and SpO2 in the same scale
#define SAMPLING 5 //if you want to see heart beat more precisely , set SAMPLING to 1
#define FINGER_ON 30000 // if red signal is lower than this , it indicates your finger is not on the sensor
#define MINIMUM_SPO2 80.0
int Num = 100;//calculate SpO2 by this sampling interval
double avered = 0; 
double aveir = 0;
double sumirrms = 0;
double sumredrms = 0;
void HeartRate()
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

  Serial.println();
  }
  
void SPO2(){
  
   uint32_t ir, red , green;
  red = particleSensor.getFIFORed(); //Sparkfun's MAX30105
    ir = particleSensor.getFIFOIR();  //Sparkfun's MAX30105
   
  double fred, fir;
  double SpO2 = 0; //raw SpO2 before low pass filtered
   
    i++;
    fred = (double)red;
    fir = (double)ir;
    avered = avered * frate + (double)red * (1.0 - frate);//average red level by low pass filter
    aveir = aveir * frate + (double)ir * (1.0 - frate); //average IR level by low pass filter
    sumredrms += (fred - avered) * (fred - avered); //square sum of alternate component of red level
    sumirrms += (fir - aveir) * (fir - aveir);//square sum of alternate component of IR level
    if ((i % SAMPLING) == 0) {//slow down graph plotting speed for arduino Serial plotter by thin out
      if ( millis() > TIMETOBOOT) {
        float ir_forGraph = (2.0 * fir - aveir) / aveir * SCALE;
        float red_forGraph = (2.0 * fred - avered) / avered * SCALE;
        //trancation for Serial plotter's autoscaling
        if ( ir_forGraph > 100.0) ir_forGraph = 100.0;
        if ( ir_forGraph < 80.0) ir_forGraph = 80.0;
        if ( red_forGraph > 100.0 ) red_forGraph = 100.0;
        if ( red_forGraph < 80.0 ) red_forGraph = 80.0;
        //        Serial.print(red); Serial.print(","); Serial.print(ir);Serial.print(".");
        if (ir < FINGER_ON) ESpO2 = MINIMUM_SPO2; //indicator for finger detached
        float temperature = particleSensor.readTemperatureF();
        
        Serial.print(" Oxygen % = ");
        Serial.println(ESpO2);
   

      }

  }
    }
float o;
float A;

void checkmlx(){

  while (!Serial);

  Serial.println("Adafruit MLX90614 test");

  if (!mlx.begin()) {
    Serial.println("Error connecting to MLX sensor. Check wiring.");
    while (1);
  };

  Serial.print("Emissivity = "); Serial.println(mlx.readEmissivity());
  Serial.println("================================================");
  }
  
void checkmax(){
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

void temp(){
  o = mlx.readObjectTempC();
  A = mlx.readAmbientTempC();
  Serial.print("Ambient = "); Serial.print(A);
  Serial.print("*C\tObject = "); Serial.print(o); Serial.println("*C");
  Serial.println();
  }

  void init_wifi() {
   WiFi.begin("Ruskee_2.4G","Ruskee39924");
  do {
    Serial.print(".");
    delay(500);
  } while ((!(WiFi.status() == WL_CONNECTED)));Serial.println("WiFi Connected");
  Serial.print("IP address: ");
  Serial.println((WiFi.localIP().toString()));
}
  void thingspeak(){ 
    if (client.connect("api.thingspeak.com",80)) {
      request_string = thingSpeakAddress;
      request_string += "key=";
      request_string += api_key;
      request_string += "&field1=";
      request_string += beatAvg;
      request_string += "&field2=";
      request_string += ESpO2;
      request_string += "&field3=";
      request_string += o;
      
      http.begin(client,request_string);
      http.GET();
      http.end();
      request_string="";

    }
    delay(15000);

    }
    
void changeState()
{
  thingspeak();  //Invert Current State of LED  
}
  void setup() {
  Serial.begin(115200);
  checkmlx();
  checkmax();
  particleSensor.begin();
  mlx.begin();
  init_wifi();
 blinker.attach(0.5, changeState);
  
}

void loop() {
  long test = particleSensor.getIR();
  if(test > 50000){
SPO2();
HeartRate();
temp();
 

  }else { Serial.print(" No finger?");}
}