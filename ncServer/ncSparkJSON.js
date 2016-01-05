//This server effectively hides the access token for the chimeSensors behind a websocket
//server. It does this by listen to the particle/netChimes server, taking the incoming message
//and rebroadcasting on port 4040

var express = require("express");
var logfmt = require("logfmt");
var app = express();

var EventSource = require('eventsource');
var esInitDict = {rejectUnauthorized: false};

var accessToken = "5a2def527bed6cbb0ac43da59cb0a836e9213b21";

// Spark URL - must use es.addEventListener and specify the event name
var url = "http://93.95.228.77:8080/v1/events/?access_token="+accessToken; //this is opening a listener to the netchimes/particle server
// var urlDevice = "http://93.95.228.77:8080/v1/devices/?access_token="+accessToken;

/*===================================
=            EventSource            =
===================================*/
var es = new EventSource(url);

// Add an event listener to listen for all and any messages named 'json' publised by the chimeSensors
es.addEventListener('json', function(e){ //the name in ' ' is the string to look for
        var rawData = JSON.parse(e.data);
        //console.log( 'listener: ', rawData.data);
        wss.broadcast(e.data);
}, false);

// esDevice.addEventListener
/*===================================
=             WebSocket             =
===================================*/

//Creates a websocket server to broadcast on port 4040 to whoever wishes to listen

var WebSocketServer = require('ws').Server
  , wss = new WebSocketServer({port: 4040});

wss.broadcast = function(data) {
    for(var i in this.clients)
        this.clients[i].send(data);
};

// use like this, on client connection and message, broadcast message to all connected:

wss.on('connection', function(ws) {
  ws.on('message', function(message) {
    wss.broadcast(message);
  });
});

