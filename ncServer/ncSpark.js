var express = require("express");
var logfmt = require("logfmt");
var app = express();

var EventSource = require('eventsource');
var esInitDict = {rejectUnauthorized: false};

var deviceID =  "53ff6b066667574823572267";	// string, your device ID
var accessToken = "799ed8fb3c52c5076e319f89f214e63b12bbd325"; // string, your access token

// Spark URL - must use es.addEventListener and specify the event name
var url = "http://localhost:8080/v1/events/?access_token="+accessToken;

// Test URL - uses es.onmessage to capture events
//var url = 'https://demo-eventsource.rhcloud.com/';

/*===================================
=            EventSource            =
===================================*/
var es = new EventSource(url);

// Only fires for Spark URL
es.addEventListener('data', function(e){
	var rawData = JSON.parse(e.data);
	console.log( 'listener: ', rawData.data);
	wss.broadcast(e.data);
}, false);

/*===================================
=             WebSocket             =
===================================*/

var WebSocketServer = require('ws').Server
  , wss = new WebSocketServer({port: 4000});

wss.broadcast = function(data) {
    for(var i in this.clients)
        this.clients[i].send(data);
};

// use like this:

wss.on('connection', function(ws) {
  ws.on('message', function(message) {
    wss.broadcast(message);
  });
});

