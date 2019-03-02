<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Uber Shep</title>
  </head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    let pastLocations = [1000, 1000, 1000, 1000, 1000];
    let index = 0;
    let avg = 0;
    let threshold = 0.3;

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
  				// printUserLocation()

          index = (index + 1) % 5;
          avg = average(pastLocations);
          closer = goodEnough();
          // index++;
          // if(index == 5) {
          //   index = index % 5;
          //
          // }
          printUserLocation();
  			}, function(error) {
  				alert('Geolocation permission denied. Default location will be set to SAL.')
  				// printUserLocation()
  			});
  		} else {
  			alert('Geolocation is not supported on this browser. Default location will be set to SAL.')
  			// printUserLocation()
  		}
  	}

    function printUserLocation() {
  		console.log('Latitude: ' + latitude)
  		console.log('Longitude: ' + longitude)
      console.log('Distance to goal: ' + distance);
      document.querySelector('#distanceUpdate').innerHTML = 'Latitude: ' + latitude + '<br />Longitude: ' + longitude + '<br/>Distance: ' + distance + '<br />Closer? ' + closer + '<br />Average: ' + avg;
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

      // fill in pastLocations array
      if(d < distance) {
        closer = true;
        pastLocations[index] = 1;
      }
      else {
        closer = false;
        pastLocations[index] = 0;
      }

      return d;
    }

    function deg2rad(deg) {
      return deg * (Math.PI/180)
    }

    function average(arr) {
      let sum = 0;
      for(let i=0; i<arr.length; i++) {
        sum += arr[i];
        console.log(arr[i]);
      }
      console.log(sum);
      return sum/arr.length;
    }

    // tells if past records good enough for happy bark
    function goodEnough() {
      return avg >= threshold;
    }

  </script>
</html>
