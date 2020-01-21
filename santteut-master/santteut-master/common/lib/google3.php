<!DOCTYPE html>
<html>
  <head>
    <title>Place ID Geocoder</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .controls {
        background-color: #fff;
        border-radius: 2px;
        border: 1px solid transparent;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        box-sizing: border-box;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        height: 29px;
        margin-left: 17px;
        margin-top: 10px;outline: none; padding: 0 11px 0 13px;text-overflow: ellipsis;width: 400px;
      }

      .controls:focus {border-color: #4d90fe;}
      .title {font-weight: bold;}
      #infowindow-content {display: none;}
      #map #infowindow-content {display: inline;}

    </style>
  </head>
  <body>
    <input type="button" name="" value="출발지 등록" onclick="input_value()">
    <input type="button" name="" value="도착지 등록" onclick="input_value2()">
    <div style="display: none">
      <input id="pac-input"
             class="controls"
             type="text"
             placeholder="출발지, 도착지를 검색하세요">
    </div>

    <div id="map"></div>
    <div id="infowindow-content">
      <span id="place-name"  class="title"></span><br>
      <strong>Place ID</strong>: <span id="place-id"></span><br>
      <span id="place-address"></span>
    </div>


// This sample requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
<script>
var location_val="";
  var geocoder;
function initMap() {
  var map = new google.maps.Map(
      document.getElementById('map'),
      {center: {lat: 37.5625008, lng: 127.035620}, zoom: 18});

  var input = document.getElementById('pac-input');

  var autocomplete = new google.maps.places.Autocomplete(input);

  autocomplete.bindTo('bounds', map);

  // Specify just the place data fields that you need.
  autocomplete.setFields(['place_id', 'geometry', 'name', 'formatted_address']);

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var infowindow = new google.maps.InfoWindow();
  var infowindowContent = document.getElementById('infowindow-content');
  infowindow.setContent(infowindowContent);

  geocoder = new google.maps.Geocoder;

  var marker = new google.maps.Marker({map: map});
  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });

  autocomplete.addListener('place_changed', function() {
    infowindow.close();
    var place = autocomplete.getPlace();
    if (!place.place_id) {
      return;
    }
    geocoder.geocode({'placeId': place.place_id}, function(results, status) {
      if (status !== 'OK') {
        window.alert('Geocoder failed due to: ' + status);
        return;
      }

      map.setZoom(11);
      map.setCenter(results[0].geometry.location);

      // Set the position of the marker using the place ID and location.
      marker.setPlace(
          {placeId: place.place_id, location: results[0].geometry.location});

      marker.setVisible(true);


      console.log(results[0].geometry.location.lat(),results[0].geometry.location.lng());
      console.log(place);

      codeLatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());

      infowindowContent.children['place-name'].textContent = place.name;
      location_val=place.name;
      infowindowContent.children['place-id'].textContent = place.place_id;
      infowindowContent.children['place-address'].textContent =
          results[0].formatted_address;
      // codeLatLng(results[0].geometry.location.lat(),results[0].geometry.location.lng());
      infowindow.open(map, marker);

    });



  });

}
function codeLatLng(lat, lng) {
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({'latLng': latlng}, function(results, status) {
    console.log(results);
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[1]) {
      var indice=0;
      for (var j=0; j<results.length; j++)
      {
        for (var i=0; i<results[j].address_components.length; i++)
        {
                if (results[j].address_components[i].types[0] == "locality" || results[j].address_components[i].types[0] == "administrative_area_level_2") {
                        //this is the object you are looking for City
                        city = results[j].address_components[i];
                    }
                if (results[j].address_components[i].types[0] == "administrative_area_level_1") {
                        //this is the object you are looking for State
                        region = results[j].address_components[i];
                    }
                if (results[j].address_components[i].types[0] == "country") {
                        //this is the object you are looking for
                        country = results[j].address_components[i];
                        break;
                }
        }

      }
          document.getElementsByName('location_val').value=location_val;
          } else {
            alert("No results found");
          }
    } else {
      alert("Geocoder failed due to: " + status);
    }
  });
}
  function input_value(){
    opener.parent.document.getElementById('p_dp_city').value=location_val;
    window.close();
  }
  function input_value2(){
    opener.parent.document.getElementById('p_arr_mt').value=location_val;
    window.close();
  }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDMwbXKZznKzOyuROSANOPHrrQdd8-wRI&libraries=places&callback=initMap"
        async defer></script>
        <input id="location_val" type="hidden" name="location_val" value="">
  </body>
</html>
