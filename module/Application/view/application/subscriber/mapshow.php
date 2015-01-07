<!DOCTYPE html>

<?php
		$conn = new mysqli("localhost","root","123456","wsn");
		if(mysqli_connect_errno()){
		    printf("Connect failed: %s\n", mysqli_connect_error());
		    exit();
		}

		$result = mysqli_query($conn, "SELECT * FROM sink");
		$temp = "";
		$str2 = "";
		$append = ",";
		while($row = mysqli_fetch_row($result)){
			$temp = implode("|", $row);
			$str2 = $str2.$temp;
			$str2 = $str2.$append;
		}
		echo "<script> var strF = \"$str2\"; </script>";
		
		$conn -> close();
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;}
#l-map{height:100%;width:78%;float:left;border-right:2px solid #bcbcbc;}
#r-result{height:100%;width:20%;float:left;}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=EZfQrPMLSMR4YvDnDMwO9r81"></script>
<title>SensorCloud</title>
</head>
<body>
<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
var map = new BMap.Map("allmap");            
var centerPoint = new BMap.Point(110.404, 37.915);
var testPoint = new BMap.Point(116.404,39.915);
map.centerAndZoom(centerPoint,5);                     
map.enableScrollWheelZoom();  

var centerMarker = new BMap.Marker(centerPoint);
var testMarker = new BMap.Marker(testPoint);
map.addOverlay(centerMarker);
map.addOverlay(testMarker);

var data = strF.split(",");
data.forEach(function(e){
	var value = e.split("|");
	var name = value[2];
	var longitude = value[3];
	var altitude = value[4];
	var point = new BMap.Point(longitude, altitude);
	var marker = new BMap.Marker(point);
	marker.addEventListener("mouseover",function(){
		var label = new BMap.Label(name,{offset:new BMap.Size(20,-10)});
		marker.setLabel(label);
	});
	map.addEventListener("click",function(e){
		<?php 
		
		?>
	});
	map.addOverlay(marker);
})

var tilelayer=new BMap.TileLayer();
tilelayer.getTilesUrl=function(){
 return "layer.gif";
};
map.addTileLayer(tilelayer);

</script>