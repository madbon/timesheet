// JavaScript Code

// Initialize the Google Maps API
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 37.7749, lng: -122.4194}, // Default center of the map
      zoom: 8 // Default zoom level of the map
    });
  
    // Add a search box to the map
    var searchBox = new google.maps.places.SearchBox(document.getElementById('search-input'));
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('search-input'));
  
    // Listen for the event when the user selects a search result
    searchBox.addListener('places_changed', function() {
      var places = searchBox.getPlaces();
  
      if (places.length == 0) {
        return;
      }
  
      // Get the location coordinates of the selected place
      var location = places[0].geometry.location;
      var lat = location.lat();
      var lng = location.lng();
  
      // Redirect to Yii2 action with lat and lng parameters
      window.location.href = '<?= Yii::$app->urlManager->createUrl(['controller/action', 'lat' => '+lat+', 'lng' => '+lng+']) ?>';
    });
  
    // Add a search button to the map
    var searchButton = document.getElementById('search-button');
    searchButton.addEventListener('click', function() {
      var query = document.getElementById('search-input').value;
  
      // Search for the query and get the location coordinates
      var geocoder = new google.maps.Geocoder();
      geocoder.geocode({ address: query }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
          var location = results[0].geometry.location;
          var lat = location.lat();
          var lng = location.lng();
  
          // Redirect to Yii2 action with lat and lng parameters
          window.location.href = '<?= Yii::$app->urlManager->createUrl(['controller/action', 'lat' => '+lat+', 'lng' => '+lng+']) ?>';
        }
      });
    });
  }
  