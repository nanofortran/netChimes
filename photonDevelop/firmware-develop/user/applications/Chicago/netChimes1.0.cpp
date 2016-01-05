/*
 ******************************************************************************
 *  Copyright (c) 2015 Particle Industries, Inc.  All rights reserved.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, see <http://www.gnu.org/licenses/>.
 ******************************************************************************
 */

 #include "application.h"


int sensor0 = 0;
int sensor1 = 1;
int sensor2 = 2;
int sensor3 = 3;
int sensor4 = 4;
int sensor5 = 5;

int sensorState0;
int sensorState1;
int sensorState2;
int sensorState3;
int sensorState4;
int sensorState5;

int sensorLat = 41981204; //your latitude to 6 significant digits the Y value or width
int sensorLon = -87666591; //your longitude to 6 significnat digits the X value or height

char* chimeCity = "Chicago"; //the name of the location the sensor is associated with (closest recognized area on a map)

char strikeString[128];
char chimeString[128];

int bounceDelay = 250;


//FUNCTIONS . . . . . . . . . . . . . . . . . . . . . . .
void strike(int chimeNum){
    sprintf(strikeString,"%i:%i:%i", sensorLat, sensorLon, chimeNum);
    sprintf(chimeString, "{\"lt\": %i, \"ln\": %i, \"cn\": %i}",sensorLat, sensorLon, chimeNum);
    Serial.println(chimeString);
    Particle.publish("data", strikeString);
    Particle.publish("json", chimeString);
}


//SETUP . . . . . . . . . . . . . . . . . . . . . . . . .
void setup() {
  pinMode(sensor0, INPUT_PULLUP);  
  pinMode(sensor1, INPUT_PULLUP);     
  pinMode(sensor2, INPUT_PULLUP);     
  pinMode(sensor3, INPUT_PULLUP);     
  pinMode(sensor4, INPUT_PULLUP);     
  pinMode(sensor5, INPUT_PULLUP);
    
    if(digitalRead(sensor0) == LOW){
        WiFi.listen();
    }

  Serial.begin(9600);
}


//RUN LOOP . . . . . . . . . . . . . . . . . . . . . . .
void loop() {
    
    if(digitalRead(sensor0) == LOW){
        //Spark.publish("Strike", "0");
        strike(0);
        Serial.println("0");
        delay(bounceDelay);
    }
    
    if(digitalRead(sensor1) == LOW){
        strike(1);
        Serial.println("1");
        delay(bounceDelay);
    }
    
    if(digitalRead(sensor2) == LOW){
        strike(2);
        Serial.println("2");
        delay(bounceDelay);
    } 
    
    if(digitalRead(sensor3) == LOW){
        strike(3);
        Serial.print("3");
        delay(bounceDelay);
    }  
    
    if(digitalRead(sensor4) == LOW){
        strike(4);
        Serial.println("4");
        delay(bounceDelay);
    }  
    
    if(digitalRead(sensor5) == LOW){
        strike(5);
        Serial.println("5");
        delay(bounceDelay);
    }
}

