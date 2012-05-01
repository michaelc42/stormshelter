var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 6,
      center: new google.maps.LatLng(40.721388,-89.272932),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
          map.setZoom(9);
		  map.panTo(marker.getPosition());
        }
      })(marker, i));
    }
    
    function goToLoc(id){
			map.setZoom(8);
			map.panTo(new google.maps.LatLng(locations[id][1], locations[id][2]));
	}
