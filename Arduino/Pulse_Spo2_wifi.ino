/*!
 * @file SPO2.ino
 * @brief Display heart-rate and SPO2 on serial in real-time, normal SPO2 is within 95~100
 * @n Try to fix the sensor on your finger in using to avoid the effect of pressure change on data output.
 * @n This library supports mainboards: ESP8266, FireBeetle-M0, UNO, ESP32, Leonardo, Mega2560
 * @copyright  Copyright (c) 2010 DFRobot Co.Ltd (http://www.dfrobot.com)
 * @licence     The MIT License (MIT)
 * @author [YeHangYu](hangyu.ye@dfrobot.com)
 * @version  V0.1
 * @date  2020-05-29
 * @url https://github.com/DFRobot/DFRobot_MAX30102
 */
 #include <Wire.h>
 #include <LiquidCrystal_PCF8574.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <DFRobot_MAX30102.h>
#include <Adafruit_MLX90614.h>
DFRobot_MAX30102 particleSensor;
Adafruit_MLX90614 mlx = Adafruit_MLX90614();
LiquidCrystal_PCF8574 lcd(0x3F);
WiFiClient client;
/*
Macro definition options in sensor configuration
sampleAverage: SAMPLEAVG_1 SAMPLEAVG_2 SAMPLEAVG_4
               SAMPLEAVG_8 SAMPLEAVG_16 SAMPLEAVG_32
ledMode:       MODE_REDONLY  MODE_RED_IR  MODE_MULTILED
sampleRate:    PULSEWIDTH_69 PULSEWIDTH_118 PULSEWIDTH_215 PULSEWIDTH_411
pulseWidth:    SAMPLERATE_50 SAMPLERATE_100 SAMPLERATE_200 SAMPLERATE_400
               SAMPLERATE_800 SAMPLERATE_1000 SAMPLERATE_1600 SAMPLERATE_3200
adcRange:      ADCRANGE_2048 ADCRANGE_4096 ADCRANGE_8192 ADCRANGE_16384
*/
String thingSpeakAddress= "http://api.thingspeak.com/update?";
String writeAPIKey;
String tsfield1Name;
String request_string;
String api_key = "EY4O6UXAM0DI1HEA";
HTTPClient http;


float o;
float A;

long prev = 0;
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
  
  void init_wifi() {
   WiFi.begin("Ruskee_2.4G","Ruskee39924");
  do {
    Serial.print(".");
    delay(500);
  } while ((!(WiFi.status() == WL_CONNECTED)));Serial.println("WiFi Connected");
  Serial.print("IP address: ");
  Serial.println((WiFi.localIP().toString()));
}
  int error;

void setup()
{ Wire.begin();
 Wire.beginTransmission(0x27);
  error = Wire.endTransmission();
  Serial.print("Error: ");
  Serial.print(error);
  //Init serial
  Serial.begin(115200);
  lcd.begin(16, 2); // initialize the lcd
  lcd.setBacklight(255);
  lcd.setCursor(0, 0);
  lcd.print(F("initialize......."));
  /*!
   *@brief Init sensor 
   *@param pWire IIC bus pointer object and construction device, can both pass or not pass parameters (Wire in default)
   *@param i2cAddr Chip IIC address (0x57 in default)
   *@return true or false
   */
   init_wifi();
   checkmlx();
   mlx.begin();
  while (!particleSensor.begin()) {
    Serial.println("MAX30102 was not found");
    delay(1000);
  }

  /*!
   *@brief Use macro definition to configure sensor 
   *@param ledBrightness LED brightness, default value: 0x1F（6.4mA), Range: 0~255（0=Off, 255=50mA）
   *@param sampleAverage Average multiple samples then draw once, reduce data throughput, default 4 samples average
   *@param ledMode LED mode, default to use red light and IR at the same time 
   *@param sampleRate Sampling rate, default 400 samples every second 
   *@param pulseWidth Pulse width: the longer the pulse width, the wider the detection range. Default to be Max range
   *@param adcRange ADC Measurement Range, default 4096 (nA), 15.63(pA) per LSB
   */
  particleSensor.sensorConfiguration(/*ledBrightness=*/50, /*sampleAverage=*/SAMPLEAVG_4, \
                        /*ledMode=*/MODE_MULTILED, /*sampleRate=*/SAMPLERATE_100, \
                        /*pulseWidth=*/PULSEWIDTH_411, /*adcRange=*/ADCRANGE_16384);
}

int32_t SPO2; //SPO2
int8_t SPO2Valid; //Flag to display if SPO2 calculation is valid
int32_t heartRate; //Heart-rate
int8_t heartRateValid; //Flag to display if heart-rate calculation is valid 
int i = 0;
int x = 0;
const byte RATE_SIZE = 4; //Increase this for more averaging. 4 is good.
byte ratesheart[RATE_SIZE]; //Array of heart rates
byte ratesspo2[RATE_SIZE]; //Array of heart rates
void loop()
{
  Serial.println(F("Wait about four seconds"));
  particleSensor.heartrateAndOxygenSaturation(/**SPO2=*/&SPO2, /**SPO2Valid=*/&SPO2Valid, /**heartRate=*/&heartRate, /**heartRateValid=*/&heartRateValid);
  if(heartRate > 20 and SPO2 > 20){
  //Print result 
      if(i < 3){
        ratesheart[i] = heartRate;
        i++; }else{ 
        ratesheart[i-1]= ratesheart[i];       
        i++;      
        if(i>3){ i = 0 ;}
        }
        heartRate = (ratesheart[0]+ratesheart[1]+ratesheart[2]+ratesheart[3])/4;
        ratesheart[i] = heartRate; 
        if(SPO2>100){SPO2 = 100; } 
        if (heartRate > 180){ heartRate = 180;}     
  Serial.print(F("heartRate="));
  Serial.print(heartRate, DEC);
  lcd.setCursor(0, 0);
  lcd.print(F("BPM= "));
  lcd.print(heartRate, DEC);
  Serial.print(F(", heartRateValid="));
  Serial.print(heartRateValid, DEC);
  Serial.print(F("; SPO2="));
  Serial.print(SPO2, DEC);
  lcd.print(F("SPO2="));
  lcd.print(SPO2, DEC);
  Serial.print(F(", SPO2Valid="));
  Serial.println(SPO2Valid, DEC);
  temp();
    if(millis() - prev >= 15000){
    thingspeak();
    prev = millis();
    }
    }else { Serial.print(" No finger?");  }
}
void temp(){
 o = mlx.readObjectTempC();
  A = mlx.readAmbientTempC();
  Serial.print("Ambient = "); Serial.print(A);
  Serial.print("*C\tObject = "); Serial.print(o); Serial.println("*C");
  lcd.setCursor(0, 1);
  lcd.print("Temp= "); lcd.print(o); lcd.println("*C");
  Serial.println();
  delay(1400);
  }

 void thingspeak(){ 
    if (client.connect("api.thingspeak.com",80)) {
      request_string = thingSpeakAddress;
      request_string += "key=";
      request_string += api_key;
      request_string += "&field1=";
      request_string += heartRate;
      request_string += "&field2=";
      request_string += SPO2;
      request_string += "&field3=";
      request_string += o;
      
      http.begin(client,request_string);
      http.GET();
      http.end();
      request_string="";

    }    
    }
 