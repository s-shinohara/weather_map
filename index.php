<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("jquery", "1.6");
</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="map.js"></script>
</head>
<body>
  <div id="test"></div>
  <div id="test2"></div>
  <div id="forcasts">
    <span id="location"></span>
    <table>
    <tr><td id="day1"></td><td id="day2"></td></tr>
    <tr><td><img id="forcast1" src="" style="visibility:hidden" /></td>
        <td><img id="forcast2" src="" style="visibility:hidden" /></td></tr>
    <tr><td id="sp1"></td><td id="sp2"></td></tr>
    </table>
  </div>
  <div id="map_canvas" style="width:100%; height:60%"></div>
<div align="right">Powered by WeatherBug</div>
</body>
</html>