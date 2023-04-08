<?php
    define("PATH_JSON", "/home/samp/lmdmtest/scriptfiles/positions.json");
    define("API_KEY", "");

    $json_pos = file_get_contents(PATH_JSON);

    if(empty(API_KEY))
        die("You need a google api key first.");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="refresh" content="60" />
        <title>SA:MP Server Graph</title>
        <style type="text/css">
            #map-canvas { display: inline-block; height: 700px; width: 700px; }
            #map-legend { padding: 10px; background-color: rgba(141, 142, 127, 0.46);}
        </style>
    </head>

    <body>
        <div id="map-canvas"></div>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="http://maps.google.com/maps/api/js?sensor=false&key=<?php echo API_KEY; ?>"></script>
        <script src="js/SanMap.min.js"></script>
        <script type="text/javascript">
            var p_pos = <?php echo (empty($json_pos)) ? "" : $json_pos ?>;

            //for each full gta sa map in whatever resolution/color/type/.. you have you should make a type for it

            var mapType = new SanMapType(0, 1, function (zoom, x, y) {
                return x == -1 && y == -1 
                ? "images/tiles/map.outer.png" 
                : "images/tiles/map." + zoom + "." + x + "." + y + ".png";
            });
            
            var satType = new SanMapType(0, 3, function (zoom, x, y) {
                return x == -1 && y == -1 
                ? null 
                : "images/tiles/sat." + zoom + "." + x + "." + y + ".png";
            });
            
            var map = SanMap.createMap(
                document.getElementById('map-canvas'),
                {'Map': mapType, 'Satellite': satType}, //specify all your types from above here
                2,
                SanMap.getLatLngFromPos(0,0), false, 'Satellite'
            );

            if(p_pos !== "")
                for (var i = 0; i < Object.keys(p_pos).length; i++) 
                    if(p_pos[i].online == 1) createMarker(i); 

            google.maps.event.addListener(map, 'click', function(event) {
                var pos = SanMap.getPosFromLatLng(event.latLng);
            }); 

            function createMarker(id)
            {
                var p_windows = new google.maps.InfoWindow({
                    content: "<p>"+p_pos[id].name+" <b>(ID: "+id+")</b><br>Ping: "+p_pos[id].ping+"</p>"
                });

                var p_marker = new google.maps.Marker({
                    position: SanMap.getLatLngFromPos(p_pos[id].x, p_pos[id].y),
                    map: map
                });

                google.maps.event.addListener(p_marker, 'click', function() {
                    p_windows.open(map,p_marker);
                });
            }
        </script>
    </body>
</html>
