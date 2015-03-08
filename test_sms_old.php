<?php
if ($_GET['nombre']=="si") {$mensajedo="(primer nombre)".$_GET['mensaje'];}
$mensaje=urlencode($mensajedo);
$url="http://touchsms.com.ve/clientes/apicall-touch.php?texto=".$mensaje."&telf=".$_GET['test']."&pass=developer&login=developer&id_cuenta=0&id_cuenta_hija=0";
$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1');
$result = curl_exec($handle);
curl_close($handle);	

$_GET['mensaje']=urlencode($_GET['mensaje']);
$go="previa_mensaje.php?mensaje=".$_GET['mensaje']."&usuarios=".$_GET['usuarios']."&destino=".$_GET['destino']."&test=1&nombre=".$_GET['nombre'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>tured.com</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="js/jquery.mobile-1.2.1.css" />
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.mobile-1.2.1.js"></script>
     <script src="jquery.validate.js"></script>
	<script src="main.js"></script>
	<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
    </script>
</head> 

<body >
<div class="ui-body-a" data-role="dialog" id="registerPage">
	
		<div data-role="header" data-theme="d">
			<h1>Prueba de envío</h1>

		</div>

  <div data-role="content" data-theme="c">
			<h4>MENSAJE ENVIADO</h4>

                        <a href="#" data-role="button"  data-theme="a" onclick="window.close()" >cerrar ventana</a>                      
	 </div>
</div>

</body>
</html>