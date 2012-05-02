<script src="http://maps.google.com/maps/api/js?sensor=false" 
	  type="text/javascript"></script>

<h4>Places We've Built Shelters</h4>

<div id="map"></div>
<div id="maplinks">
	<ul> 
		<li><h6>Click a Location</h6></li>
		<?php $i = 0; ?>
		<?php foreach ( $locations as $value ): ?>
			<li><a href="#map" onclick="goToLoc(<?php echo $i;?>)"><?php echo $value->name; ?></a></li>
			<?php $i++; ?>
		<?php endforeach; ?>	
	</ul>
</div>
  
<script type="text/javascript">
	var locations=[
		<?php
		foreach ($locations as $value)
		{
			echo "['".$value->name."',".$value->latlong.",".$value->zindex."],";
			
		}	
		?>
	];
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
</script>