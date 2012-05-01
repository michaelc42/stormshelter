<script src="http://maps.google.com/maps/api/js?sensor=false" 
	  type="text/javascript"></script>

<?php

  /* Array connsists of Name, LatLong, and z-index of marker*/
    $locations=array(
		array('Based In Eureka, IL', '40.721388,-89.272932', 1),
		array('Peoria Heights, IL', '40.753499,-89.569016', 4),
		array('Springfield, IL', '39.786379,-89.644547', 5),
		array('Davenport, IA', '41.533254,-90.577698', 3)
	);
?>

<h4>Places We've Built Shelters</h4>

<div id="map" style="float: left; width: 500px; height: 400px;"></div>
<div style="float:left" id="maplinks">
	<ul>  
		<?php foreach ( $locations as $key=>$value ): ?>
			<li><a href="#map" onclick="goToLoc(<?php echo $key;?>)"><?php echo $value[0]; ?></a></li>
		<?php endforeach; ?>	
	</ul>
</div>
  
<script type="text/javascript">
	var locations=[
		<?php
		foreach ($locations as $value)
		{
			echo "['".$value[0]."',".$value[1].",".$value[2]."],";
			
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
