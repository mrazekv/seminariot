Bezpečnost vestavěných systémů - *Seminář pro studenty SŠ "IT a bezpečnost"*
==============================



### Prezentace ###

[<i class="icon-provider-gdrive"></i> Google Dokument](https://docs.google.com/presentation/d/1sUErDtJMu-sDf1eJhjGv_D8pvDge2YkUTx2nQOzZXFg/edit?usp=sharing)

### Cvičení ###
V tomto demu si postupně naprogramujete jednoduchý IoT modul, který bude snímat teplotu vzduchu pomocí čidla na shieldu, tuto teplotu odesílat na server a podle pokynů obdržených ze serveru rozsvěcovat LED (v demu jsou pokyny generovány náhodně, bez ohledu na naměřenou teplotu).

Abychom získali skutečný systém pro regulaci vytápění, stačí místo LED připojit například relé pro spínání kotle nebo serva pro regulaci ventilů topení a na serveru doplnit řídicí logiku a případnou agregaci dat z více senzorů (např. snímače vlhkosti, předpověď počasí na internetu a další).

Wemos D1 mini budeme programovat pomocí Arduino IDE s příslušnými rozšířeními. 

**Kostra programu**
Připravili jsme pro vás kostru programu, do které budete doplňovat vlastní kód. Obsahuje definice potřebných proměnných a knihoven. 

```arduino
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
const String server = "dhcpz244.fit.vutbr.cz";

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
```

Vaším prvním úkolem je doplnění vašeho ID do konstanty myId. Správnou hodnotu naleznete na titulní stránce tohoto textu.

Kostra dále obsahuje konstanty s adresou serveru a jménem a heslem WiFi sítě, ke kterým se modul připojí. Ty měnit nemusíte.

Vašim úkolem bude postupně doplňovat kód dvou funkcí:
 
 - funkce setup() se zavolá vždy pouze jednou a slouží k inicializaci 
 - funkce loop() se volá neustále dokola (bez zpoždění) a měla by obsahovat hlavní funkcionalitu (v našem případě čtení teploty a komunikaci)

Poté, co si otevřete kostru v Arduino IDE, zkontrolujte, zda je zvolena správná deska a port:
v menu Tools -> Board by mělo být  “Wemos D1 R2 & Mini”
v menu Tools -> Port by mělo být nejčastěji COM3 (modul se může objevit i pod jiným číslem, ale prakticky nikdy to není COM1)


**Řešení**
Abyste si mohli odzkoušet práci s deskou i doma, nabízíme vám vyřešené úkoly ke stažení. Můžete se podívat i na zdrojový kód jednoduchého nezabezpečeného serveru implementovaného pomocí PHP.