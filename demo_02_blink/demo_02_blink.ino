/***
   Blikani LEDkami pomoci ESP8266
   Sprava dalsich desek: http://arduino.esp8266.com/stable/package_esp8266com_index.json
   Deska: WeMOS D1 & D1 mini

   Zapojeni GPIO pinu:
       5 - Dallas DS18B20
       4 - LED1
       0 - LED2
       2 - LED3
*/

const int led1 = 4;
const int led2 = 0;
const int led3 = 2;


void setup() {
  Serial.begin(115200);
  while (!Serial) {
    ;  // vyckej na inicializaci
  }

  pinMode(led1, OUTPUT);
  pinMode(led2, OUTPUT);
  pinMode(led3, OUTPUT);

  digitalWrite(led1, LOW);
  digitalWrite(led2, LOW);
  digitalWrite(led3, LOW);
}

void loop() {
  digitalWrite(led1, HIGH);
  digitalWrite(led2, HIGH);
  digitalWrite(led3, HIGH);
  delay(500);

  digitalWrite(led1, LOW);
  digitalWrite(led2, LOW);
  digitalWrite(led3, LOW);
  delay(500);
}
