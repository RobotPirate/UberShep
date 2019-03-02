<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Uber Shep</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>

    </style>
  </head>
  <body>
    <div class="shepherdLogo">

    </div>

    <div id="landingPage">
      <button>Start Shep</button>
    </div>

    <div id="shepherdPage">
      <div id="distanceUpdate">
        Move towards your pickup location.
      </div>
      <button>Stop Shep</button>
    </div>
  </body>
  <script
  	src="https://code.jquery.com/jquery-3.3.1.min.js"
  	integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  	crossorigin="anonymous">
	</script>
  <script>
    // initialize variables for user's and destination coords
    let latitude = 0;
    let longitude = 0;
    let destLatitude = 34.139137;
    let destLongitude = -118.125471;
    let distance = 0;
    let closer = false;
    let pastLocations = [1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000, 1000];
    let index = 0;
    let avg = 0;

    let happyAudio = new Audio('cow_moo.mp3');
    let sadAudio = new Audio('devil_dog.mp3');

    // get the pickup location from API
    $(document).ready(function() {
      ajax();
    });

    // prints every 5 seconds location on console
    setInterval(function() {
      getLocation();
    }, 2000);

    // gets location of user from geolocation
    function getLocation() {
  		if ("geolocation" in navigator) {
  			navigator.geolocation.getCurrentPosition(function(position) {
  				latitude = position.coords.latitude
  				longitude = position.coords.longitude
          distance = getDistanceFromLatLonInM(latitude, longitude, destLatitude, destLongitude);

          index = (index + 1) % pastLocations.length;
          avg = average(pastLocations);
          printUserLocation();
  			}, function(error) {
  				alert('Geolocation permission denied. Default location will be set to SAL.');
  			});
  		} else {
  			alert('Geolocation is not supported on this browser. Default location will be set to SAL.');
  		}
  	}

    function printUserLocation() {
  		console.log('Latitude: ' + latitude)
  		console.log('Longitude: ' + longitude)
      console.log('Distance to goal: ' + distance);
      document.querySelector('#distanceUpdate').innerHTML = 'Latitude: ' + latitude + '<br />Longitude: ' + longitude + '<br/>Distance: ' + distance + '<br />Distance 9 times ago: ' + pastLocations[(index+5)%pastLocations.length] + '<br />Closer? ' + closer + '<br />Average: ' + avg;
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
      console.log('index: ' + index);
      if(d < pastLocations[(index+1)%pastLocations.length]) {
        closer = true;
        happyAudio.play();
      }
      else {
        closer = false;
        sadAudio.play();
      }
      pastLocations[index] = d;

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

    function ajax() {
      $.ajax({
        method: 'POST',
        url: 'index.js',
        data: {
          action: 'getPickup'
        }
      }).done(function(results) {
        if(results == null) {
          console.log('AJAX error: returned null object')
        }
        else { // calculate the pickup location based on results
          getPickup(JSON.parse(results));
        }
      });
      return false;
    }

    // set pickup data based on API results
    function getPickup(results) {
      destLatitude = results.latitude;
      destLongitude = results.longitude;
    }
  </script>
</html>
