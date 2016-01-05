//netChimes world map visualization 1.0

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

///////VISUALIZATION

var mapWidth = 800;
var mapHeight = 400;

var worldMap;//this holds the map which is currently sized mapWidth x mapHeight
							//map for netchimes.com is 
var droplets = []; //an array of droplets (dynamic)



function setup() {
	window.resizeTo(mapWidth, mapHeight);
	var theCanvas = createCanvas(mapWidth, mapHeight); //we set the canvas size, rather the size of the active space
  	theCanvas.parent("map");
	frameRate(30); //no need to burn so many cycles
}

function draw() {
	image(worldMap,0,0); //place the map
	
	//some text
	push();
	noStroke();
	fill(100);
	textAlign(CENTER);
	textSize(24);
	textStyle(NORMAL);
	text("Live data from the netChimes sensor in Chicago, Illinois.", width/2, height - 70);
	textSize(16);
	push();
	textStyle(ITALIC);
	text("If there is no wind, there is no data. Additional sensors to be added globally Summer 2015.", width/2, height - 30);
	pop();
	
	
	for(var i = 0; i < droplets.length; i++){ //iterate through the droplets array
		droplets[i].plot(); //plot() is the the sole function
		}
}

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

/*
function mouseClicked(){
	chime0.volume(.5);
	chime0.play();
	c = color(255, 0, 255, 255); //color will be changed due to conditions, but hardcoded here
	droplets.unshift(new Drop(mouseX * .7, mouseY * .7, 5, c));
	print(droplets.length);
}
*/



