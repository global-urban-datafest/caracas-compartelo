<?php
$link=mysql_connect("localhost", "root", "");
mysql_select_db("localizacion",$link) or die ("Error: No es posible establecer la conexión");
?>
<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
  <title>Google Maps Multiple Markers</title> 
  <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
</head> 
<body>
<input type="hidden" name="txt_lat_actual" id="txt_lat_actual">
<input type="hidden" name="txt_long_actual" id="txt_long_actual">
<?php
$sql=mysql_query("SELECT direccion.Rif, direccion.id_parroquia, direccion.latitud, direccion.longitud, direccion.direccion,
estado.nombre as nombre_estado, municipio.nombre as nombre_municipio, parroquias.nombre as nombre_parroquia,
tipo_empresas.ruta_img, empresas.empresa_nombre as nombre_empresa
FROM tured.empresas
inner join tured.tipo_empresas on tipo_empresas.id = empresas.id_tipo_empresa
inner join tured.direccion on direccion.Rif = empresas.empresa_rif
inner join tured.parroquias on direccion.id_parroquia = parroquias.id
inner join tured.municipio on parroquias.gid_municipio = municipio.gid_municipio
inner join tured.estado  on municipio.id_geo_estado = estado.id
group by empresas.id_tipo_empresa");  

$rows	=mysql_num_rows($sql);
$contador=1;
$localizaciones_var='[';
while($result=mysql_fetch_array($sql)){
$Direccion=	$result["Rif"].", ".	$result["nombre_empresa"].", ".$result["nombre_estado"].", ".$result["nombre_municipio"].", ".$result["nombre_parroquia"];

?>
<input type="hidden" name="txt_lat_<?=$i?>" id="txt_lat_<?=$i?>" value="<?=$result["latitud"]?>">
<input type="hidden" name="txt_long_<?=$i?>" id="txt_long_<?=$i?>" value="<?=$result["longitud"]?>">
<input type="hidden" name="txt_dir_<?=$i?>" id="txt_dir_<?=$i?>" value="<?=$Direccion?>">
<input type="hidden" name="txt_cantidad" id="txt_cantidad" value="<?=$rows?>">

<?php

$direccion = $result["ruta_img"];
$localizaciones_var=$localizaciones_var."['<h4>".utf8_encode($Direccion)."</h4>', ".$result["latitud"].",".$result["longitud"].",'".$direccion."']";

	if($contador!=$rows){
		$localizaciones_var=$localizaciones_var.",";
	}

}

$localizaciones_var	=	$localizaciones_var.']';
?> 
<div style="width:100%" align="center">
  <div id="map" style="width: 700px; height: 400px;" align="center"></div>
  </div>
  <script>

    // Define your locations: HTML content for the info window, latitude, longitude
   /*
   var cantidad_filas	=	 document.getElementById("txt_cantidad").value;
	
	var j	=	1;
	var localizaciones_1='[';
	for(i_=1;i_<=cantidad_filas;i_++){
	
		var localizaciones_1 =localizaciones_1+"['<h4>Chacao venezuela</h4>', 10.4938681, -66.85658869999997]";
		 
		 if(i_!=j){
		 	localizaciones+= ',';
		 }
		 
	}
	
	localizaciones_1+="]"
	
	
    var locations = [
      ['<h4>Chacao venezuela</h4>', 10.4938681, -66.85658869999997, direccion],
      ['<h4>Coogee Beach</h4>', -33.923036, 151.259052],
      ['<h4>Cronulla Beach</h4>', -34.028249, 151.157507],
      ['<h4>Manly Beach</h4>', -33.80010128657071, 151.28747820854187],
      ['<h4>Maroubra Beach</h4>', -33.950198, 151.259302]
    ];
	*/
    
	<?php
	//$localizaciones_var="[['<h4>Chacao venezuela</h4>', 10.4938681, -66.85658869999997]]";
	?>
 var locations = <?=$localizaciones_var?>;
 
 //alert(localizaciones_1);
	
    // Setup the different icons and shadows
    var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
   
   
   
    var icons = [
      iconURLPrefix + 'red-dot.png',
      iconURLPrefix + 'green-dot.png',
      iconURLPrefix + 'blue-dot.png',
      iconURLPrefix + 'orange-dot.png',
      iconURLPrefix + 'purple-dot.png',
      iconURLPrefix + 'pink-dot.png',      
      iconURLPrefix + 'yellow-dot.png'
    ]


	
    var iconsLength = icons.length;



	
			
			
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      //center: new google.maps.LatLng(latitud, longitud),
      center: new google.maps.LatLng(-37.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      mapTypeControl: false,
      streetViewControl: false,
      panControl: false,
      zoomControlOptions: {
         position: google.maps.ControlPosition.LEFT_BOTTOM
      }
    });

//FUNCION QUE CENTRA EN EL MAPA SEGUN MI COLOCACION ACTUAL
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			//alert(position.coords.latitude+"--"+ position.coords.longitude);
            map.setCenter(initialLocation);
        });
    }
	
	
    var infowindow = new google.maps.InfoWindow({
      maxWidth: 160
    });

    var markers = new Array();
    
    var iconCounter = 0;
    
    // Add the markers and infowindows to the map
    for (var i = 0; i < locations.length; i++) {  
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
       // icon: icons[iconCounter]
	   icon: locations[i][3]
      });

      markers.push(marker);

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
      
      iconCounter++;
      // We only have a limited number of possible icon colors, so we may have to restart the counter
      if(iconCounter >= iconsLength) {
      	iconCounter = 0;
      }
    }

    function autoCenter() {
      //  Create a new viewpoint bound
      var bounds = new google.maps.LatLngBounds();
      //  Go through each...
      for (var i = 0; i < markers.length; i++) {  
	  
		/*if(i==0){
		
		var ubic_actual= "("+document.getElementById("txt_lat_actual").value+", "+document.getElementById("txt_long_actual").value+")";
		
		//bounds.extend(document.getElementById("txt_lat_actual").value,document.getElementById("txt_long_actual").value);

		}*/
			bounds.extend(markers[i].position);

     }
      //  Fit these bounds to the map
      map.fitBounds(bounds);
    }
	
	/* function localize()
		{
		 	if (navigator.geolocation)
			{
                navigator.geolocation.getCurrentPosition(mapa,error);
            }
            else
            {
                alert('Tu navegador no soporta geolocalizacion.');
            }
		}

		function mapa(pos)
		{
		/************************ Aqui están las variables que te interesan***********************************/
			/*var latitud = pos.coords.latitude;
			var longitud = pos.coords.longitude;
			var precision = pos.coords.accuracy;
			document.getElementById("txt_lat_actual").value="10.128920031648272";
			document.getElementById("txt_long_actual").value="-67.96468734741211";
			autoCenter();
		}
			function error(errorCode)
		{
			if(errorCode.code == 1)
				alert("No has permitido buscar tu localizacion")
			else if (errorCode.code==2)
				alert("Posicion no disponible")
			else
				alert("Ha ocurrido un error")
		}
	localize();*/

  </script> 
  
<?php
$query	=	mysql_query("SELECT * FROM tipo_empresas");

 ?>
 

 <table align="center">
 <tr><td> Leyenda</td></tr>
 <?php
 while($result_1	=	mysql_fetch_array($query)){
 ?>
 <tr>
 <td><img src="<?=$result_1["ruta_img"]?>" width="20" height="20"></td>
 <td><?=utf8_encode($result_1["nombre"])?></td>
 </tr>
 <?php } 
 ?>
 </table>
</body>
</html>