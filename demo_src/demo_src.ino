/***
   Snimani teploty pomoci ESP8266
   Sprava dalsich desek: http://arduino.esp8266.com/stable/package_esp8266com_index.json
   Deska: WeMOS D1 & D1 mini

   Zapojeni GPIO pinu:
       5 - Dallas DS18B20
       4 - LED1
       0 - LED2
       2 - LED3
*/

const int DS18B20 = 5;
const int led1 = 4;
const int led2 = 0;
const int led3 = 2;

// knihovna pro komunikaci po sbernici OneWire
#include <OneWire.h>

// knihovna pro praci s teplotnim cidlem
#include <DallasTemperature.h>

// knihovna pro praci s WiFi
// definuje globalni promennou WiFi
#include <ESP8266WiFi.h>

// knihovna pro komunikaci po HTTP
#include <ESP8266HTTPClient.h>

// jmeno site a heslo pro pripojeni
const char* ssid = "FITIOT2";
const char* password = "IOTFITVUTBR";

// adresa serveru
const String server = "192.168.0.100";

// vase ID
const int myId = 12;

// vytvoreni instance HTTP klienta z knihovny ESP8266HTTPClient
HTTPClient http;

// vytvoreni instance oneWireDS z knihovny OneWire
OneWire oneWireDS(DS18B20);

// vytvoreni instance senzoryDS z knihovny DallasTemperature
DallasTemperature senzoryDS(&oneWireDS);

void setup() {
  /* vas kod inicializace patri sem */
}

void loop() {
  /* vas kod patri sem */
}
