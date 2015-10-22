<?php
	define(PATH_JSON, "/home/samp/lmdmtest/scriptfiles/positions.json");
	$json_pos = file_get_contents(PATH_JSON);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="refresh" content="60" />
		<title>SA:MP Server Graph</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    	<style type="text/css">
        	#map-canvas { display: inline-block; height: 700px; width: 700px; }
        	#map-legend { padding: 10px; background-color: rgba(141, 142, 127, 0.46);}
    	</style>
	</head>

	<body>
        <div id="map-canvas"></div>
        <div id="map-legend">
        	<h2>Legend</h2>
        	<p><img src="http://wiki.sa-mp.com/wroot/images2/1/15/Icon_56.gif" /> Players (click to view data)</p>
        </div>

        <script src="js/SanMap.min.js"></script>
		<script type="text/javascript">
			var p_pos = <?php echo (empty($json_pos)) ? "" : $json_pos ?>;

			var mapType = new SanMapType(0, 1, function (zoom, x, y) {
		        return x == -1 && y == -1 
				? "images/tiles/map.outer.png" 
				: "images/tiles/map." + zoom + "." + x + "." + y + ".png";//Where the tiles are located
		    });
			
		    var satType = new SanMapType(0, 3, function (zoom, x, y) {
		        return x == -1 && y == -1 
				? null 
				: "images/tiles/sat." + zoom + "." + x + "." + y + ".png";//Where the tiles are located
		    });
			
		    var map = SanMap.createMap(document.getElementById('map-canvas'), 
				{'Map': mapType, 'Satellite': satType}, 2, SanMap.getLatLngFromPos(0,0), false, 'Satellite');

		    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(document.getElementById('map-legend'));

		    if(p_pos !== "")
		    {
		    	for (var i = 0; i < Object.keys(p_pos).length; i++) 
		    	{
		    		console.log(p_pos[i].online);
					if(p_pos[i].online == 1) createMarker(i); 
		    	}
			}	

			google.maps.event.addListener(map, 'click', function(event) {
				var pos = SanMap.getPosFromLatLng(event.latLng);
				console.log(pos.x + "," + pos.y);
		    }); 

			function createMarker(id)
			{
				var p_windows = new google.maps.InfoWindow({
		    		content: "<p>"+p_pos[id].name+" <b>(ID: "+id+")</b><br>Ping: "+p_pos[id].ping+"</p>"
		    	});

		    	var p_marker = new google.maps.Marker({
		    		position: SanMap.getLatLngFromPos(p_pos[id].x, p_pos[id].y),
		    		map: map,
		    		icon: "http://wiki.sa-mp.com/wroot/images2/1/15/Icon_56.gif"
		    	});

				google.maps.event.addListener(p_marker, 'click', function() {
					p_windows.open(map,p_marker);
				});
			}
		</script>
	</body>
</html>
