<html>
  <head>
    <title>Add Map</title>
    <link rel="icon" type="image/x-icon" href="{{asset('img/manektech.png')}}">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <style type="text/css">
      #map_canvas {
        height: 100%;
        width: 100%;
      }
    </style>
  </head>
  <body>
    <div id="map_canvas"></div>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDclFLYFbBbBFEKSWGPcKSxlReVWKhURQg&libraries=places"></script>
  </body>
</html>
<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript">
  function initialize() {
          var lat = {{$lat}};
          var long = {{$long}};
          var mapOptions = {
              center: new google.maps.LatLng(lat, long),
              zoom: 13,
              mapTypeId: google.maps.MapTypeId.ROADMAP
          };
          var map = new google.maps.Map(document.getElementById('map_canvas'),
          mapOptions);          

          var infowindow = new google.maps.InfoWindow();
          var marker = new google.maps.Marker({
              map: map
          });

          marker.setPosition(mapOptions.center);
  }
  google.maps.event.addDomListener(window, 'load', initialize);

</script>