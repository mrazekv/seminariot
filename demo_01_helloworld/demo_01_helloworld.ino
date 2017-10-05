/***
   Hello World pres seriovou linku ESP8266
   Sprava dalsich desek: http://arduino.esp8266.com/stable/package_esp8266com_index.json
   Deska: WeMOS D1 & D1 mini

   Zapojeni GPIO pinu:
       5 - Dallas DS18B20
       4 - LED1
       0 - LED2
       2 - LED3
*/

void setup() {
  Serial.begin(115200);
  while (!Serial) {
    ;  // vyckej na inicializaci
  }
}

void loop() {
  Serial.println("Hello world!");
}
