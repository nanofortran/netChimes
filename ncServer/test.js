//this code pulls the list of all netChimes node registered with the server as a JSON file that are connected

var request = require('request');
var deviceList;

var jsonfile = require('jsonfile');
var file = 'devices.json';




request('http://93.95.228.77:8080/v1/devices?access_token=5a2def527bed6cbb0ac43da59cb0a836e9213b21', function (error, response, query) {
  if (!error && response.statusCode == 200) {
  	deviceList = query;

  	jsonfile.writeFile(file, deviceList, function (err) {
  	console.error(err)
	})
    //console.log(theList);
	}
})

