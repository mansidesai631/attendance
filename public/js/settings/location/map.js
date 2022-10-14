//Map Functionality
initialize();
$("#location_latitude").attr('disabled',true);
$("#location_longitude").attr('disabled',true);

// Add address from Google Location
function initialize() {

    var mapOptions = {
        center: new google.maps.LatLng(23.022505, 72.5713621),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    var map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

    var input = document.getElementById('location_address');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map
    });
    

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17); 
        }

        var image = new google.maps.MarkerImage(
            place.icon,
            new google.maps.Size(71, 71),
            new google.maps.Point(0, 0),
            new google.maps.Point(17, 34),
            new google.maps.Size(35, 35)
        );

        const cityCircle = new google.maps.Circle({
          strokeColor: "#FF0000",
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: "#FF0000",
          fillOpacity: 0.35,
          map,
          center: place.geometry.location,
          radius: $("#location_radius").val() * 100,
        });

        marker.setIcon(image);
        marker.setPosition(place.geometry.location);
        updateTextFields(place.geometry.location.lat(),place.geometry.location.lng());
    });        
}

function updateTextFields(lat, lng) {
    $('#location_latitude').val(lat);
    $('#location_longitude').val(lng);
    var address = $('#location_address').val();

    $('input[name="location_latitude"]').val(lat);
    $('input[name="location_longitude"]').val(lng);
    $('input[name="location_address"]').val(address);
}    

// Add lat long
function add_lat_long(){
    if($("#location_latitude").val() != "" && $("#location_longitude").val() != ""){
        var lat = parseFloat($("#location_latitude").val());
        var long = parseFloat($("#location_longitude").val());

        const mapOptions = {
           zoom: 8,
           center: { lat: lat, lng: long },
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);
        const marker = new google.maps.Marker({
            position: { lat: lat, lng: long },
            map: map,
        });

        const cityCircle = new google.maps.Circle({
          strokeColor: "#FF0000",
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: "#FF0000",
          fillOpacity: 0.35,
          map,
          center: mapOptions.center,
          radius: $("#location_radius").val() * 100,
        });

        // This is making the Geocode request
        var latlng = new google.maps.LatLng(lat, long);
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
            if (status !== google.maps.GeocoderStatus.OK) {
            }
            // This is checking to see if the Geoeode Status is OK before proceeding
            if (status == google.maps.GeocoderStatus.OK) {
                var address = (results[0].formatted_address);
                $("#location_address").val(address);

                $('input[name="location_latitude"]').val(lat);
                $('input[name="location_longitude"]').val(long);

                $('input[name="location_address"]').val(address);
            }
        });



    }
}

function change_radius(){
    if($("#location_latitude").val() != "" && $("#location_longitude").val() != ""){
        var lat = parseFloat($("#location_latitude").val());
        var long = parseFloat($("#location_longitude").val());

        const mapOptions = {
           zoom: 13,
           center: { lat: lat, lng: long },
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);
        const marker = new google.maps.Marker({
            position: { lat: lat, lng: long },
            map: map,
        });

        const cityCircle = new google.maps.Circle({
          strokeColor: "#FF0000",
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: "#FF0000",
          fillOpacity: 0.35,
          map,
          center: mapOptions.center,
          radius: $("#location_radius").val() * 100,
        });
    }
}

$("#location_latitude").keyup(function(){
    add_lat_long();
});

$("#location_longitude").keyup(function(){
    add_lat_long();
});

$("#location_radius").keyup(function(){
    change_radius();
});

// $("#location_radius").keyup(function(){
//     initialize();
// });

$(document).on('change','input[name="address_type"]',function(event){
    if($(this).val() == 1){
        $("#location_latitude").attr('disabled',false);
        $("#location_longitude").attr('disabled',false);

        $("#location_address").attr("disabled",true);

    }else{
        $("#location_latitude").attr('disabled',true);
        $("#location_longitude").attr('disabled',true);
        $("#location_address").attr("disabled",false);
    }
});

// Edit time Add address from Google Location
function edit_initialize() {
    var lat = $('#edit_location_latitude').val();
    var long = $('#edit_location_longitude').val();

    var mapOptions = {
        center: new google.maps.LatLng(lat, long),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    var map = new google.maps.Map(document.getElementById('edit-map-canvas'),
        mapOptions);
    var input = document.getElementById('edit_location_address');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map
    });

    const cityCircle = new google.maps.Circle({
      strokeColor: "#FF0000",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "#FF0000",
      fillOpacity: 0.35,
      map,
      center: mapOptions.center,
      radius: $("#edit_location_radius").val() * 100,
    });
    marker.setPosition(mapOptions.center);

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17); 
        }

        var image = new google.maps.MarkerImage(
            place.icon,
            new google.maps.Size(71, 71),
            new google.maps.Point(0, 0),
            new google.maps.Point(17, 34),
            new google.maps.Size(35, 35)
        );

        const cityCircle = new google.maps.Circle({
          strokeColor: "#FF0000",
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: "#FF0000",
          fillOpacity: 0.35,
          map,
          center: place.geometry.location,
          radius: $("#edit_location_radius").val() * 100,
        });

        marker.setIcon(image);
        marker.setPosition(place.geometry.location);
        editupdateTextFields(place.geometry.location.lat(),place.geometry.location.lng());
    });        
}

function editupdateTextFields(lat, lng) {
    $('#edit_location_latitude').val(lat);
    $('#edit_location_longitude').val(lng);
    var address = $('#edit_location_address').val();

    $('input[name="edit_location_latitude"]').val(lat);
    $('input[name="edit_location_longitude"]').val(lng);
    $('input[name="edit_location_address"]').val(address);
}

// Edit time Add lat long
function edit_add_lat_long(){
    if($("#edit_location_latitude").val() != "" && $("#edit_location_longitude").val() != ""){
        var lat = parseFloat($("#edit_location_latitude").val());
        var long = parseFloat($("#edit_location_longitude").val());

        const mapOptions = {
           zoom: 13,
           center: { lat: lat, lng: long },
        };
        var map = new google.maps.Map(document.getElementById('edit-map-canvas'),
        mapOptions);
        const marker = new google.maps.Marker({
            position: { lat: lat, lng: long },
            map: map,
        });

        const cityCircle = new google.maps.Circle({
          strokeColor: "#FF0000",
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: "#FF0000",
          fillOpacity: 0.35,
          map,
          center: mapOptions.center,
          radius: $("#edit_location_radius").val() * 100,
        });

        // This is making the Geocode request
        // var latlng = new google.maps.LatLng(lat, long);
        // var geocoder = new google.maps.Geocoder();
        // geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
        //     if (status !== google.maps.GeocoderStatus.OK) {
        //     }
        //     if (status == google.maps.GeocoderStatus.OK) {
        //         var address = (results[0].formatted_address);
        //         $("#edit_location_address").val(address);

        //         $('input[name="edit_location_latitude"]').val(lat);
        //         $('input[name="edit_location_longitude"]').val(long);
        //         $('input[name="edit_location_address"]').val(address);
        //     }
        // });



    }
}

// Edit time Add lat long
function edit_add_lat_long1(){
    if($("#edit_location_latitude").val() != "" && $("#edit_location_longitude").val() != ""){
        var lat = parseFloat($("#edit_location_latitude").val());
        var long = parseFloat($("#edit_location_longitude").val());

        const mapOptions = {
           zoom: 13,
           center: { lat: lat, lng: long },
        };
        var map = new google.maps.Map(document.getElementById('edit-map-canvas'),
        mapOptions);
        const marker = new google.maps.Marker({
            position: { lat: lat, lng: long },
            map: map,
        });

        const cityCircle = new google.maps.Circle({
          strokeColor: "#FF0000",
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: "#FF0000",
          fillOpacity: 0.35,
          map,
          center: mapOptions.center,
          radius: $("#edit_location_radius").val() * 100,
        });

        //This is making the Geocode request
        var latlng = new google.maps.LatLng(lat, long);
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
            if (status !== google.maps.GeocoderStatus.OK) {
            }
            if (status == google.maps.GeocoderStatus.OK) {
                var address = (results[0].formatted_address);
                $("#edit_location_address").val(address);

                $('input[name="edit_location_latitude"]').val(lat);
                $('input[name="edit_location_longitude"]').val(long);
                $('input[name="edit_location_address"]').val(address);
            }
        });



    }
}    

$("#edit_location_latitude").keyup(function(){
    edit_add_lat_long1();
});

$("#edit_location_longitude").keyup(function(){
    edit_add_lat_long1();
});

$("#edit_location_radius").keyup(function(){
    edit_add_lat_long();
});

$("#edit_location_address").keyup(function(){
    edit_initialize();
});

// Enable disable text by selecting radio buttons
$(document).on('change','input[name="edit_address_type"]',function(event){
    if($(this).val() == 1){
        $("#edit_location_latitude").attr('disabled',false);
        $("#edit_location_longitude").attr('disabled',false);
        $("#edit_location_address").attr("disabled",true);
    }else{
        $("#edit_location_latitude").attr('disabled',true);
        $("#edit_location_longitude").attr('disabled',true);
        $("#edit_location_address").attr("disabled",false);
    }
});
