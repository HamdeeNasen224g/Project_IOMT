#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <SoftwareSerial.h>
#include "MAX30100_PulseOximeter.h"
#define RX 2
#define TX 3
#define REPORTING_PERIOD_MS 1000

String AP = "Free-wifi2.4G";       // AP NAME
String PASS = ""; // AP PASSWORD
String API = "EY4O6UXAM0DI1HEA";   // Write API KEY
String HOST = "api.thingspeak.com";
String PORT = "80";
int countTrueCommand;
int countTimeCommand; 
boolean found = false; 
int valSensor = 1;

SoftwareSerial esp8266(RX,TX); 
LiquidCrystal_I2C lcd(0x27, 16, 2); 
PulseOximeter pox;

uint32_t tsLastReport = 0;

int sensor_pin = 0;                

int led_pin = 13;          

volatile int heart_rate;          

volatile int analog_data;              

volatile int time_between_beats = 600;            

volatile boolean pulse_signal = false;    

volatile int beat[10];         //heartbeat values will be sotred in this array    

volatile int peak_value = 512;          

volatile int trough_value = 512;        

volatile int thresh = 525;              

volatile int amplitude = 100;                 

volatile boolean first_heartpulse = true;      

volatile boolean second_heartpulse = false;    

volatile unsigned long samplecounter = 0;   //This counter will tell us the pulse timing

volatile unsigned long lastBeatTime = 0;

void onBeatDetected()
{
    Serial.println("Beat!");
}
 
void setup()
{  
  Serial.begin(9600);  
  esp8266.begin(115200);
  sendCommand("AT",5,"OK");
  sendCommand("AT+CWMODE=1",5,"OK");
    sendCommand("AT+CWJAP=\""+ AP +"\",",20,"OK");
  
   pinMode(led_pin,OUTPUT);      
   interruptSetup(); 
   
   lcd.backlight();
   Serial.print("Initializing pulse oximeter..");  
    lcd.begin(16,2);  
    lcd.print("Initializing...");
    delay(3600);
    lcd.clear();
   
    // Initialize the PulseOximeter instance
    // Failures are generally due to an improper I2C wiring, missing power supply
    // or wrong target chip
    if (!pox.begin()) {
        Serial.println("FAILED");
        for(;;);
    } else {
        Serial.println("SUCCESS");
    }
     pox.setIRLedCurrent(MAX30100_LED_CURR_7_6MA);

} 
void loop()
{    
  String getData = "GET /update?api_key="+ API +"&field1="+pox.getHeartRate()+"&field2="+pox.getSpO2();
  sendCommand("AT+CIPMUX=1",5,"OK");
  sendCommand("AT+CIPSTART=0,\"TCP\",\""+ HOST +"\","+ PORT,15,"OK");
  sendCommand("AT+CIPSEND=0," +String(getData.length()+4),4,">");
  esp8266.println(getData);delay(1500);countTrueCommand++;
  sendCommand("AT+CIPCLOSE=0",5,"OK");
 
}
String getPulseoxiValue(){
// Register a callback for the beat detection
    pox.setOnBeatDetectedCallback(onBeatDetected);
   
    // Make sure to call update as fast as possible
    pox.update();
    if (millis() - tsLastReport > REPORTING_PERIOD_MS) {
        Serial.print("Heart rate:");
        Serial.print(pox.getHeartRate());
        Serial.print("bpm / SpO2:");
        Serial.print(pox.getSpO2());
        Serial.println("%");

        lcd.clear();
        lcd.setCursor(0,0);
        lcd.print("BPM : ");
        lcd.print(pox.getHeartRate());

        lcd.setCursor(0,1);
        lcd.print("SpO2 : ");
        lcd.print(pox.getSpO2());
        lcd.print("%");

        tsLastReport = millis();
            
    }
}
void sendCommand(String command, int maxTime, char readReplay[]) {
  Serial.print(countTrueCommand);
  Serial.print(". at command => ");
  Serial.print(command);
  Serial.print(" ");
  while(countTimeCommand < (maxTime*1))
  {
    esp8266.println(command);//at+cipsend
    if(esp8266.find(readReplay))//ok
    {
      found = true;
      break;
    }
  
    countTimeCommand++;
  }
  
  if(found == true)
  {
    Serial.println("OYI");
    countTrueCommand++;
    countTimeCommand = 0;
  }
  
  if(found == false)
  {
    Serial.println("Fail");
    countTrueCommand = 0;
    countTimeCommand = 0;
  }
  
  found = false;
 }
 
void interruptSetup()

{    

  TCCR2A = 0x02;  // This will disable the PWM on pin 3 and 11

  OCR2A = 0X7C;   // This will set the top of count to 124 for the 500Hz sample rate

  TCCR2B = 0x06;  // DON'T FORCE COMPARE, 256 PRESCALER

  TIMSK2 = 0x02;  // This will enable interrupt on match between OCR2A and Timer

  sei();          // This will make sure that the global interrupts are enable

}

ISR(TIMER2_COMPA_vect)

{ 

  cli();                                     

  analog_data = analogRead(sensor_pin);            

  samplecounter += 2;                        

  int N = samplecounter - lastBeatTime;      


  if(analog_data < thresh && N > (time_between_beats/5)*3)

    {     

      if (analog_data < trough_value)

      {                       

        trough_value = analog_data;

      }

    }


  if(analog_data > thresh && analog_data > peak_value)

    {        

      peak_value = analog_data;

    }                          



   if (N > 250)

  {                            

    if ( (analog_data > thresh) && (pulse_signal == false) && (N > (time_between_beats/5)*3) )

      {       

        pulse_signal = true;          

        digitalWrite(led_pin,HIGH);

        time_between_beats = samplecounter - lastBeatTime;

        lastBeatTime = samplecounter;     



       if(second_heartpulse)

        {                        

          second_heartpulse = false;   

          for(int i=0; i<=9; i++)    

          {            

            beat[i] = time_between_beats; //Filling the array with the heart beat values                    

          }

        }


        if(first_heartpulse)

        {                        

          first_heartpulse = false;

          second_heartpulse = true;

          sei();            

          return;           

        }  


      word runningTotal = 0;  


      for(int i=0; i<=8; i++)

        {               

          beat[i] = beat[i+1];

          runningTotal += beat[i];

        }


      beat[9] = time_between_beats;             

      runningTotal += beat[9];   

      runningTotal /= 10;        

      heart_rate = 60000/runningTotal;

    }                      

  }




  if (analog_data < thresh && pulse_signal == true)

    {  

      digitalWrite(led_pin,LOW); 

      pulse_signal = false;             

      amplitude = peak_value - trough_value;

      thresh = amplitude/2 + trough_value; 

      peak_value = thresh;           

      trough_value = thresh;

    }


  if (N > 2500)

    {                          

      thresh = 512;                     

      peak_value = 512;                 

      trough_value = 512;               

      lastBeatTime = samplecounter;     

      first_heartpulse = true;                 

      second_heartpulse = false;               

    }


  sei();                                

}
