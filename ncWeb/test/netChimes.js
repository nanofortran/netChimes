var wsUrl = "ws://93.95.228.77:4040";

//Audio

var chime0;
var chime1;
var chime2;
var chime3;
var chime4;
var chime5;

chime0 = new Howl ({urls: ["assets/audio/chime0.mp3"]});
chime1 = new Howl ({urls: ["assets/audio/chime1.mp3"]});
chime2 = new Howl ({urls: ["assets/audio/chime2.mp3"]});
chime3 = new Howl ({urls: ["assets/audio/chime3.mp3"]});
chime4 = new Howl ({urls: ["assets/audio/chime4.mp3"]});
chime5 = new Howl ({urls: ["assets/audio/chime5.mp3"]});

var southWest = L.latLng(-80, -170),
    northEast = L.latLng(80, 170),
    bounds = L.latLngBounds(southWest, northEast);    

// var base = new L.tileLayer( 'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
//   attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
//   maxZoom: 10,
//   minZoom: 2,
//   noWrap: true
// });


var base = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="http://cartodb.com/attributions">CartoDB</a>',
  subdomains: 'abcd',
  maxZoom: 10,
  minZoo: 2,
  noWrap: true
});

var map = new L.Map('map', {
  layers: [base],
  center: new L.LatLng(8, 0),
  zoom: 2,
  maxBounds: bounds
  // fullscreenControl: true,
  // fullscreenControlOptions: { 
  //   // optional
  //   title:"Show me the fullscreen !",
  //   titleCancel:"Exit fullscreen mode"
  // },
});

map.scrollWheelZoom.disable();
// map.fitBounds(bounds);

L.terminator().addTo(map)

// detect fullscreen toggling
map.on('enterFullscreen', function(){
  if(window.console) window.console.log('enterFullscreen');
});
map.on('exitFullscreen', function(){
  if(window.console) window.console.log('exitFullscreen');
});

// define 6 icon classes for different chime tones, use with icons[0] .. icons[5]
var icons = [
  L.divIcon({className: 'map-marker green'}),
  L.divIcon({className: 'map-marker red'}),
  L.divIcon({className: 'map-marker blue'}),
  L.divIcon({className: 'map-marker yellow'}),
  L.divIcon({className: 'map-marker orange'}),
  L.divIcon({className: 'map-marker purple'}),
];

var cities = 
  L.divIcon({className: 'map-cityMarker'});

function wsOpen (url) {
  var w = new WebSocket(url);
  w.onopen = function (e) { onOpen(e); }
  w.onclose = function (e) { onClose(e); }
  w.onmessage = function (e) { onMessage(e); }
  w.onerror = function (e) { onError(e); }
  return w;
}

function onOpen () {
  // TODO: keep an internal state about the websocket (optional)
}

function onClose () {
  // TODO: reconnect immediatly or after a grace period
}

function onError () {
  // TODO: reconnect after a grace period
}

function onMessage (e) {
  var data = JSON.parse(e.data);
  var chime = JSON.parse(data.data);

  if (chime.cn == 0) {
    chime0.volume(.5);
    chime0.play();
  }
  
  if (chime.cn == 1) {
    chime1.volume(.5);
    chime1.play();
  }
  
  if (chime.cn == 2) {
    chime2.volume(.5);
    chime2.play();
  }
  
  if (chime.cn == 3) {
    chime3.volume(.5);
    chime3.play();
  }
  
  if (chime.cn == 4) {
    chime4.volume(.5);
    chime4.play();
  }
  
  if (chime.cn == 5) {
    chime5.volume(.5);
    chime5.play();
  }

  //console.log('Adding marker', chime.lt/1000000, chime.ln/1000000, chime);
  


  var marker = L.marker(

    // position the marker at the geo-location, but the leaflet decide it's
    // screen position based on zoom and pan of the map
    //
    // [chime.lt/1000000, chime.ln/1000000],
    [chime.lt, chime.ln],

    // pick the right icon class (color/style)
    {icon: icons[chime.cn]}

  ).addTo(map);



  // Using pure Javascript to add an event listener
  //
  marker._icon.addEventListener('animationend', function () {
    // console.log('Animation ends, removing marker from map', marker._latlng.lat, marker._latlng.lng);

    // does not work, removing markers is just not intended by leaflet
    //
    // marker.removeFrom(map);

    // does not work either, actually calls marker.removeFrom() internally
    //
    // map.removeControl(marker);

    // removes DOM node of the icon, but still keeps marker in later
    //
    marker._removeIcon();
  });
}


// cityMarkers
var Chicago = L.latLng(41.981204,-87.666591);
var Seattle = L.latLng(47.654859,-122.306767);
var Bournemouth = L.latLng(50.720000,-1.880000);
var Melbourne = L.latLng(-37.896254,145.064815);
//var Hilda = L.latLng(30.586851, -99.114495);
//var Tromso = L.latLng(69.649208, 18.955324);
//var Seoul = L.latLng(37.565833, 126.978888);
var Stockholm = L.latLng(59.3333333, 18.05);
var Tokyo = L.latLng(35.652832, 139.839478);

var locations = [Chicago, Seattle, Bournemouth, Melbourne, Tokyo, Stockholm];

for (var i = 0; i < locations.length; i++){
var marker = new L.marker(locations[i], {icon: cities}).addTo(map);
// console.log(i);
}

//console.log('opening websocket', wsUrl);
wsOpen(wsUrl);
