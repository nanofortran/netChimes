README 

As the photon firmware currently does not allow for the use of printf (%f), that is publishing numbers that are floats (go figure), we are sending the latitude and longitude as signed integers (so, 66.456789 is actually sent as 665456789 and then divided by 1000000 in the sketchPhotonHack.js to make the numbers work out . . . ugly.)

21 August 2015