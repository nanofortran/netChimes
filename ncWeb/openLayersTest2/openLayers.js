// JavaScript Document

////////NETWORK

var wsUri = "ws://93.95.228.77:4040";
var c;

///AUDIO

var chime0;
var chime1;
var chime2;
var chime3;
var chime4;
var chime5;

function preload(){
worldMap = loadImage("assets/images/WorldMap.jpg"); //load the map for the background
chime0 = new Howl ({urls: ["assets/audio/chime0.mp3"]});
chime1 = new Howl ({urls: ["assets/audio/chime1.mp3"]});
chime2 = new Howl ({urls: ["assets/audio/chime2.mp3"]});
chime3 = new Howl ({urls: ["assets/audio/chime3.mp3"]});
chime4 = new Howl ({urls: ["assets/audio/chime4.mp3"]});
chime5 = new Howl ({urls: ["assets/audio/chime5.mp3"]});
}


function runWebSocket(){
			websocket = new WebSocket(wsUri);
			websocket.onopen = function(evt) { onOpen(evt) };
			websocket.onclose = function(evt) { onClose(evt) };
			websocket.onmessage = function(evt) { onMessage(evt) };
			websocket.onerror = function(evt) { onError(evt) };
}

runWebSocket(); //this function runss the websocket functions (continuos)

function onOpen(evt){
	//alert("I need to connect to the netChimes server.\n\nWhat say thee?");
}

function onMessage(evt){
	var rawData = JSON.parse(evt.data);
	var chimeData = JSON.parse(rawData.data);
	
	var lat = map(chimeData.ln/1000000, -180, 180, 0, mapWidth); //width
	var lon =map(chimeData.lt/1000000, 90, -90, 0, mapHeight); // height
	var selection = chimeData.cn;
	
	if (selection == 0) {
		c = color(255,0,0);
		chime0.volume(.5);
		chime0.play();
	}
	
	if (selection == 1) {
		c = color(0,255,0);
		chime1.volume(.5);
		chime1.play();
	}
	
	if (selection == 2) {
		c = color(0,0,255);
		chime2.volume(.5);
		chime2.play();
	}
	
	if (selection == 3) {
		c = color(255,255,0);
		chime3.volume(.5);
		chime3.play();
	}
	
	if (selection == 4) {
		c = color(255,0,255);
		chime4.volume(.5);
		chime4.play();
	}
	
	if (selection == 5) {
		c = color(0,255,255);
		chime5.volume(.5);
		chime5.play();
	}
	
	droplets.unshift(new Drop(lat, lon, 5, c)); //create a new instance of the droplet
	
	//console.log("Sensor #" + selection);
}

//modify below

var droplets = []; //an array of droplets (dynamic)

function setup(){
	init();
}

function draw(){
	for(var i = 0; i < droplets.length; i++){ //iterate through the droplets array
		droplets[i].plot(); //plot() is the the sole function
		}
}


//draw and handle map
function init(){
var map = new ol.Map({
  layers: [
    new ol.layer.Tile({
      source: new ol.source.OSM({
        wrapX: false
      })
    })
  ],
  controls: ol.control.defaults({
    attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
      collapsible: false
    })
  }),
  target: 'map',
  view: new ol.View({
    center: [0, 0],
    zoom: 2
  })
});

var vector = new ol.layer.Vector({
  source: source
});
}

map.addLayer(vector);

map.addControl(new OpenLayers.Control.EditingToolbar(vector));

function Drop(x, y, sz, c){
this.x = x;
this.y = y;
this.sz = sz;
this.c = c;
this.alph = 255;
}

Drop.prototype.plot = function(){ //we extend the Drop object/class with the plot function()
   
   push();
   noFill();		
   strokeWeight(2);
   	this.c.rgba[3] = this.alph; //rgba is an array held in the color() object, so we change the 4th element, alpha
	stroke(this.c); 
	ellipse(this.x, this.y, this.sz, this.sz);
	this.alph -= 2;
	this.sz += 1;
	pop();

	if(this.alph < 0){
	shorten(droplets);
   }
}	

function mouseClicked(){
	chime0.volume(.5);
	chime0.play();
	//addRandomFeature();
	c = color(255, 0, 255, 255); //color will be changed due to conditions, but hardcoded here
	droplets.unshift(new Drop(mouseX * .7, mouseY * .7, 5, c));
	print(droplets.length);
}





//HERE this adds events . . .

/*
function addRandomFeature() {
  var x = mouseX;
  var y = mouseY;
  var geom = new ol.geom.Point(ol.proj.transform([x, y],
      'EPSG:4326', 'EPSG:3857'));
  var feature = new ol.Feature(geom);
  source.addFeature(feature);
}




var duration = 500;

function flash(feature) {
  var start = new Date().getTime();
  var listenerKey;

  function animate(event) {
    var vectorContext = event.vectorContext;
    var frameState = event.frameState;
    var flashGeom = feature.getGeometry().clone();
    var elapsed = frameState.time - start;
    var elapsedRatio = elapsed / duration;
    // radius will be 5 at start and 30 at end.
    var radius = ol.easing.easeOut(elapsedRatio) * 100 + 5;
    var opacity = ol.easing.easeOut(1 - elapsedRatio);

    var flashStyle = new ol.style.Circle({
      radius: radius,
      snapToPixel: false,
      stroke: new ol.style.Stroke({
        color: 'rgba(255, 0, 0, ' + opacity + ')',
        width: 1
      })
    });

    vectorContext.setImageStyle(flashStyle);
    vectorContext.drawPointGeometry(flashGeom, null);
    if (elapsed > duration) {
      ol.Observable.unByKey(listenerKey);
      return;
    }
    // tell OL3 to continue postcompose animation
    frameState.animate = true;
  }
  listenerKey = map.on('postcompose', animate);
}

source.on('addfeature', function(e) {
  flash(e.feature);
});

//window.setInterval(addRandomFeature, 1000);

*/