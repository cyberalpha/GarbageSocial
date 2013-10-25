window.onload = googleMaps; 

function googleMaps() {
	var lat = 0;
	var lng = 0;
	var zoom = 2;
    geocoder = new google.maps.Geocoder();
    var myLatlng = new google.maps.LatLng(lat, lng);
    var myOptions = {
      zoom: zoom,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    var marker = new google.maps.Marker({
        position: myLatlng, 
        map: map
    });
    google.maps.event.addListener(map, "center_changed", function(){
      document.getElementById("latitude").value = map.getCenter().lat();
      document.getElementById("longitude").value = map.getCenter().lng();
      marker.setPosition(map.getCenter());
      document.getElementById("zoom").value = map.getZoom();
    });
    google.maps.event.addListener(map, "zoom_changed", function(){
      document.getElementById("zoom").value = map.getZoom();
    });
  }
