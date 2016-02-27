//===========
//Setup all defines
//==========
#define SWVer 0.1	//Define Software version

#define WiFiReconnect 3	//How many time to try connecting to Wifi during connection attempts

#define SSID ""			//WiFi SSID
#define PASS ""	//WiFi Password

#define IP "192.168.1.26" 	// Gardnr Base IP address

#define Temp_Analog A0
#define Light_Analog A1
#define Moisture_analog A2

#define voltageFlipPin1 7
#define voltageFlipPin2 8

//===End Defines===

// Setup Variables

String GET = "GET /ping.php";
String CloseGet =" HTTP/1.1\r\nHost: "IP"\r\nConnection: close\r\n\r\n";
String GET2 = "GET /adddata.php";

char wificonnected=0;

int datavalues[3];  //Array to Hold Analog Readings to Send



void setup() {	//Initial Setup

	pinMode(13, OUTPUT);	//test
	digitalWrite(13, LOW);//test
	
	//===Setup Moisture Sensor Pins===
	pinMode(voltageFlipPin1, OUTPUT);
	pinMode(voltageFlipPin2, OUTPUT);
	//===End Setup of Moisture Sensor===
	
	//===Setup the ESP8266===
	delay (1000);//Add a delay to settle all voltages and ESP8266 to start
	
	Serial.begin(9600);	//Set ESP8266 Serial Communication Speed

	Serial.println("AT");	//Ping ESP8266 and wait for Response
	
	delay(5000);	//Wait for reply from Wifi
	
	if(Serial.find("OK")){	//ESP8266 responded
		digitalWrite(13, HIGH);
		connectWiFi();
	}
	//===End Setup of ESP8266===

}//End Setup


void loop()   
{
	datavalues[0] = analogRead(Temp_Analog);	//Read Temp Analog Pin
	datavalues[1] = analogRead(Light_Analog);	//Read Light Analog Pin

	
	setSensorPolarity(true);
	delay(500);
	int val1 = analogRead(Moisture_analog);
	delay(500);
	setSensorPolarity(false);
	delay(500);
	// invert the reading
	int val2 = 1023 - analogRead(Moisture_analog);
	delay(500);
	datavalues[2] = reportLevels(val1,val2);
	turnoffmoisture();
	
	
	
	PingNode();
	uploadData(datavalues[0] , datavalues[1] ,datavalues[2] , datavalues[0] );
	delay(60000);

	
}	//End of Loop()

void PingNode(){
	String response;
	
	//Ping the Server
	String cmd = "AT+CIPSTART=\"TCP\",\"";
	cmd += IP;
	cmd += "\",80";
	Serial.println(cmd);
	delay(2000);
	if(Serial.find("Error")){
		return;
	}
	
	cmd = GET;
	cmd += "?id=1";	//Set Module ID
	cmd += "&v=";
	cmd += SWVer;	//Set the Version from Define
	cmd += CloseGet;
	cmd += "\r\n";
	Serial.print("AT+CIPSEND=");
	Serial.println(cmd.length());
	if(Serial.find(">")){
		Serial.print(cmd);
	}else{
		Serial.println("AT+CIPCLOSE");
	}
	
	
	
	delay(5000);
	
	//TEST====================
	//while (Serial.available()) {
	//	char c = Serial.read(); // read the next character. this is because it prints one char at a time
	//	response += c;
	//	delay(50);
	//}
	//Serial.print(response);
	
	/*
	
	
	 int  charCount = 0;
	String statusStr = "";
	//Serial.print(cmd);

	//if ( Serial.find("status: ")) {
	    char c;
	    while (Serial.available() == 0); //wait for data
	    
	    while (Serial.available())
	    {
	      c = Serial.read();
	    
		statusStr += c;
	      charCount++;
	      delay(50); //wait for more data. fixme: can this be smaller?
	    }


	  Serial.print("status=");
	      Serial.println(statusStr);
	    
 // }

  delay(1000);
	
	*/
	
	

	
	
	
	


}
void connectWiFi(){	//Connect to WiFi
	char connect_attempts=0;	//Variable to keep track of attempts
	
	while((wificonnected == 0) && (connect_attempts < WiFiReconnect)){
		connect_attempts++;	//Increase attempt count
		
		Serial.println("AT+CWMODE=1");	//Set Mode
		
		delay(2000);
		
		String cmd="AT+CWJAP=\"";
		cmd+=SSID;
		cmd+="\",\"";
		cmd+=PASS;
		cmd+="\"";
		Serial.println(cmd);
			
		delay(5000);	//Delay to give it time to respond
		
		if(Serial.find("OK")){
			wificonnected = 1;	//Connected to WiFi
		}else{
			wificonnected = 0;	//Connection Failed
		}
	}
}

void uploadData(int temp, int light, int moisture, int stemp){
	
	
	//Upload to Server
	String cmd = "AT+CIPSTART=\"TCP\",\"";
	cmd += IP;
	cmd += "\",80";
	Serial.println(cmd);
	delay(2000);
	if(Serial.find("Error")){
		return;
	}
	
	cmd = GET2;
	cmd += "?id=1&temp=";
	cmd += temp;
	cmd += "&light=";
	cmd += light;
	cmd += "&moisture=";
	cmd += moisture;
	cmd += "&stemp=";
	cmd += stemp;
	cmd += CloseGet;
	cmd += "\r\n";
	Serial.print("AT+CIPSEND=");
	Serial.println(cmd.length());
	if(Serial.find(">")){
		Serial.print(cmd);
	}else{
		Serial.println("AT+CIPCLOSE");
	}
	
}
	

void setSensorPolarity(boolean flip){	//Set Moisture Pins voltage depending on reading desired
	if(flip){
		digitalWrite(voltageFlipPin1, HIGH);
		digitalWrite(voltageFlipPin2, LOW);
	}else{
		digitalWrite(voltageFlipPin1, LOW);
		digitalWrite(voltageFlipPin2, HIGH);
	}
}

int reportLevels(int val1,int val2){	//Return the average of both readings
	int avg = (val1 + val2) / 2;

	return avg;
}

void turnoffmoisture(){	//Turn off Voltages for Moisture Pins to prevent corroding of sensor
	digitalWrite(voltageFlipPin1, LOW);
	digitalWrite(voltageFlipPin2, LOW);
}

void CheckWiFiConnected(){ //Checks if Connected to WiFi
	
	Serial.println("AT+CWJAP?");
	
	delay(5000);	//Wait for reply from Wifi
	
	if(Serial.find("ERROR")){	//Wifi not connected
		wificonnected = 0; //set global variable
		connectWiFi();	//Attempt to Reconnect to WiFi
	} else {
		wificonnected = 1; //set global variable
	}
}