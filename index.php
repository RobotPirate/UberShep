<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Uber Shep</title>
  </head>
  <style>

  </style>
  <body>
    <div id="distanceUpdate">
      Move towards your point of meeting.
    </div>
  </body>
  <script>
    // initialize variables for user's and destination coords
    let latitude = 0;
    let longitude = 0;
    let destLatitude = 34.139137;
    let destLongitude = -118.125471;
    let distance = 0;
    let closer = false;

    // prints every 5 seconds location on console
    setInterval(function() {
      getLocation();
    }, 5000);

    // gets location of user from geolocation
    function getLocation() {
  		if ("geolocation" in navigator) {
  			navigator.geolocation.getCurrentPosition(function(position) {
  				latitude = position.coords.latitude
  				longitude = position.coords.longitude
          distance = getDistanceFromLatLonInM(latitude, longitude, destLatitude, destLongitude);
  				printUserLocation()
  			}, function(error) {
  				alert('Geolocation permission denied. Default location will be set to SAL.')
  				printUserLocation()
  			});
  		} else {
  			alert('Geolocation is not supported on this browser. Default location will be set to SAL.')
  			printUserLocation()
  		}
  	}

    function printUserLocation() {
  		console.log('Latitude: ' + latitude)
  		console.log('Longitude: ' + longitude)
      console.log('Distance to goal: ' + distance);
      document.querySelector('#distanceUpdate').innerHTML = 'Latitude: ' + latitude + '<br />Longitude: ' + longitude + '<br/>Distance: ' + distance + '<br />Closer? ' + closer;
  	}

    function getDistanceFromLatLonInM(lat1,lon1,lat2,lon2) {
      var R = 6371; // Radius of the earth in km
      var dLat = deg2rad(lat2-lat1);  // deg2rad below
      var dLon = deg2rad(lon2-lon1);
      var a =
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon/2) * Math.sin(dLon/2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
      var d = R * c * 1000; // Distance in m

      if(d < distance) {
        closer = true;
      }
      else {
        closer = false;
      }
      return d;
    }

    function deg2rad(deg) {
      return deg * (Math.PI/180)
    }

  </script>
</html>
