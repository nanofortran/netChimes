
function setup(){

  var osmLayer = new ol.layer.Tile({
    source: new ol.source.OSM()
  });

  var birmingham = ol.proj.transform([-1.81185, 52.44314],
    'EPSG:4326', 'EPSG:3857');

  var view = new ol.View({
    center: birmingham,
    zoom: 12
  });

  var map = new ol.Map({
    target: 'map'
  });

  map.addLayer(osmLayer);

  map.setView(view);

}

function draw(){

}

