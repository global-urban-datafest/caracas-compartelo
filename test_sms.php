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
 
function loadXMLDoc(epa)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
}
xmlhttp.open("GET",epa,true);
xmlhttp.send();
}
</script>
</head> 

<body onload="<?php
if ($_GET['nombre']=="si") {$_GET['mensaje']="(primer nombre)".$_GET['mensaje'];}
$_GET['mensaje']=urlencode($_GET['mensaje']);
$url="http://touchsms.com.ve/clientes/apicall-touch.php?texto=".$_GET['mensaje']."&telf=".$_GET['test']."&pass=developer&login=developer&id_cuenta=0&id_cuenta_hija=0";
  echo "loadXMLDoc('".$url."'),";	
?>fino()" >
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