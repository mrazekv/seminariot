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
const char* ssid = "FITIOT";
const char* password = "IOTFITVUTBR";

// adresa serveru
String server = "dhcpz244.fit.vutbr.cz";

// vase ID
const int myId = 13;

// vytvoreni instance HTTP klienta z knihovny ESP8266HTTPClient
HTTPClient http;

// vytvoreni instance oneWireDS z knihovny OneWire
OneWire oneWireDS(DS18B20);

// vytvoreni instance senzoryDS z knihovny DallasTemperature
DallasTemperature senzoryDS(&oneWireDS);

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

  WiFi.begin(ssid, password);
}

void loop() {
  senzoryDS.requestTemperatures();
  Serial.print("Aktualni teplota: ");
  Serial.println(senzoryDS.getTempCByIndex(0));

  if (WiFi.status() == WL_CONNECTED) {
    String url = "http://" + server + "/write.php?id=" + myId + "&temp=" + senzoryDS.getTempCByIndex(0) + "&note=Kvak";

    Serial.print("HTTP URL: ");
    Serial.println(url);
    
    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0) {
      Serial.printf("HTTP GET... code: %d\n", httpCode);
      
      if (httpCode == HTTP_CODE_OK) {
        String payload = http.getString();

        int val = payload.toInt();
        digitalWrite(led1, val & 0x01 ? HIGH : LOW);
        digitalWrite(led2, val & 0x02 ? HIGH : LOW);
        digitalWrite(led3, val & 0x04 ? HIGH : LOW);
      }
    } else {
      Serial.printf("HTTP GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }
    http.end();
    
  } else {
    Serial.println("Offline");
  }
}
