#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10
#define RST_PIN 9
#define RELAY_PIN A5 // relay

MFRC522 rfid(SS_PIN, RST_PIN);

void setup()
{
    Serial.begin(9600);
    SPI.begin();                  // SPI bus
    rfid.PCD_Init();              // MFRC522
    pinMode(RELAY_PIN, OUTPUT);   // initializar pin como salida.
    digitalWrite(RELAY_PIN, LOW); // desactivar el relay
}

void loop()
{
    if (rfid.PICC_IsNewCardPresent())
    { 
        if (rfid.PICC_ReadCardSerial())
        { 
            MFRC522::PICC_Type piccType = rfid.PICC_GetType(rfid.uid.sak);
            digitalWrite(RELAY_PIN, HIGH); // activar relay por 700ms
            delay(700);
            digitalWrite(RELAY_PIN, LOW);

            String tag = "i-";
            for (int i = 0; i < rfid.uid.size; i++)
            {
                tag.concat(String(rfid.uid.uidByte[i] < 0x10 ? "0" : ""));
                tag.concat(String(rfid.uid.uidByte[i], HEX));
                tag.toUpperCase();
            }
            Serial.println(tag);
            tag = "";
            rfid.PICC_HaltA();     
            rfid.PCD_StopCrypto1();
            delay(5000); // pausar la operacion por 5 segundos
        }
    }
}