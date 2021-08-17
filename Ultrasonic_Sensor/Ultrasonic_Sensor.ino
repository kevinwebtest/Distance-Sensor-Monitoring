#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>
#include <SPI.h>

#define trigPin D0
#define echoPin D1

float distanceData, duration, distance;
const char* ssid = "MALAGA 07";
const char* password = "komputer";
char server[] = "proyeksms.000webhostapp.com";   
WiFiClient client;    

void setup()
{
 Serial.begin(115200);
  delay(10);
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  
  // Menyambung ke Wi-Fi
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
 
  WiFi.begin(ssid, password);
 
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
 
  // Memulai koneksi server
  Serial.println("Server started");
  Serial.print(WiFi.localIP());
  delay(1000);
  Serial.println(" connecting...");
 }
void loop()
{ 
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);
  duration = pulseIn(echoPin, HIGH);
  distance = (duration/2) / 29.1;
  distanceData = distance;
  Sending_To_phpmyadmindatabase(); 
  delay(5000); // Menghitung nilai yang didapat sensor setiap 5 detik
 }

 void Sending_To_phpmyadmindatabase()   //Proses mengirim data sensor ke database
 {
   if (client.connect(server, 80)) {
    Serial.println("connected");
    Serial.print("GET /ultrasonic/ultrasonic.php?distance=");
    client.print("GET /ultrasonic/ultrasonic.php?distance=");   // Melakukan request HTTP
    Serial.println(distanceData);
    client.print(distanceData);
    client.print(" HTTP/1.1");
    client.println();
    client.print("Host: ");
    client.println(server);
    client.println("Connection: close");
    client.println();
    } 
    else {
    // Jika koneksi gagal
    Serial.println("connection failed");
    }
}
