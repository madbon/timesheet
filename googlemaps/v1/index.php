In the JavaScript code above, we first initialize the Google Maps API by creating a new map object and setting the default center and zoom level. We then add a search box to the map using the SearchBox class provided by the API.

We listen for the places_changed event on the search box, which fires when the user selects a search result. We get the location coordinates of the selected place and redirect to a Yii2 action with the lat and lng parameters.

We also add a search button to the map, which allows the user to search for a location by entering a query in the search box. We use the Geocoder class provided by the API to geocode the query and get the location coordinates. We then redirect to a Yii2 action with the lat and lng parameters.

Note that in the Yii2 action, you can get the lat and lng parameters using the Yii::$app->request->get() method, like so:

// Yii2 Code
public function actionIndex() {
  $lat = Yii::$app->request->get('lat');
  $lng = Yii::$app->request->get('lng');

  // Use the lat and lng parameters to do something
}
