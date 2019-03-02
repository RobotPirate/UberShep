<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Uber Shep</title>
  </head>
  <body>
    <div class="distanceUpdate">
      Move towards your point of meeting.
    </div>
  </body>
  <script>
    // gets location of user from geolocation
    function getLocation() {
  		if ("geolocation" in navigator) {
  			navigator.geolocation.getCurrentPosition(function(position) {
  				latitude = position.coords.latitude
  				longitude = position.coords.longitude
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
  	}

    let latitude = 0;
    let longitude = 0;
    setInterval(function() {
      getLocation();
    }, 5000);

  </script>
</html>
