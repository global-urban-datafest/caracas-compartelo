<?php require_once('Connections/local.php'); ?>
<?php

$hora=date("H:i:s");
$fecha=date("d/m/Y");
$dia=date("N");

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php?error=2";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
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
<script>
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
<?php  

if($_GET['destino']=="todos") {
mysql_select_db($database_local, $local);
$query_Recordset1 = "SELECT * FROM usuarios where empresa_id='".$_SESSION['MM_UserGroup']."'";
$Recordset1 = mysql_query($query_Recordset1, $local) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$mensaje=urlencode($_GET['mensaje']); }

else 

{
	mysql_select_db($database_local, $local);
$query_Recordset1 = "SELECT * FROM usuarios WHERE telf IN (".$_GET['destino'].") and empresa_id='".$_SESSION['MM_UserGroup']."' GROUP BY telf";
 
$Recordset1 = mysql_query($query_Recordset1, $local) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$mensaje=urlencode($_GET['mensaje']);
	
	}
$sale="";
 do { 
 

$cantidad_sms="-1";			
$detalle_sms="Mensaje enviado a los telefonos:".$row_Recordset1['telf'];
$sale=$row_Recordset1['telf'].",".$sale;
$hora=date("H:i:s");
$fecha=date("d/m/Y");
$dia=date("N");
$menssax=urldecode($mensaje);
$insertCredito = "insert into creditos (creditos,fecha_in,empresa_id,descr,detalle,mensaje) values ('".$cantidad_sms."','".$fecha."-".$hora."','".$_SESSION['MM_UserGroup']."','Mensaje Directo','".$detalle_sms."','".$menssax."')";
mysql_select_db($database_local, $local);
$Result2 = mysql_query($insertCredito, $local) or die(mysql_error());			
			 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
			 
$url="http://touchsms.com.ve/clientes/apicall-touch.php?texto=".$nombre_url."+".$mensaje."&telf=".$sale."&pass=developer&login=developer&id_cuenta=0&id_cuenta_hija=0";               
          
function SendSMS ($host, $port, $username, $password, $phoneNoRecip, $msgText) { 

/* Parameters:
    $host - IP address or host name of the NowSMS server
    $port - "Port number for the web interface" of the NowSMS Server
    $username - "SMS Users" account on the NowSMS server
    $password - Password defined for the "SMS Users" account on the NowSMS Server
    $phoneNoRecip - One or more phone numbers (comma delimited) to receive the text message
    $msgText - Text of the message
*/
 
    $fp = fsockopen($host, $port, $errno, $errstr);
    if (!$fp) {
        echo "errno: $errno \n";
        echo "errstr: $errstr\n";
        return $result;
    }
    
    fwrite($fp, "GET /?Phone=" . rawurlencode($phoneNoRecip) . "&Text=" . rawurlencode($msgText) . " HTTP/1.0\n");
    if ($username != "") {
       $auth = $username . ":" . $password;
       $auth = base64_encode($auth);
       fwrite($fp, "Authorization: Basic " . $auth . "\n");
    }
    fwrite($fp, "\n");
  
    $res = "";
 
    while(!feof($fp)) {
        $res .= fread($fp,1);
    }
    fclose($fp);
    
 
    return $res;
}
    $host="200.75.136.182";
    $port="8800";
    $username="developer";
    $password="developer";
    $phoneNoRecip=$sale;
    $msgText=urldecode($mensaje);
 $i=SendSMS($host, $port, $username, $password, $phoneNoRecip, $msgText);
$fecha=date("d/m/Y H:i:s");

			 
			 ?>
<body >
<div class="ui-body-b" data-role="dialog">
	
		<div data-role="header" data-theme="d">
			<h1>Aviso</h1>

		</div>

  <div data-role="content" data-theme="c">
			<h4>Mensaje Enviado!</h4>
            
			</p>
			<?php if($_GET['origen']=="multiple") {echo "<a href=\"multiples.php\" data-role=\"button\"  data-theme=\"b\" rel=\"external\">Continuar</a>";} else {{echo "<a href=\"reporte.php\" data-role=\"button\"  data-theme=\"b\" rel=\"external\">Continuar</a>";}}?>
            
            
             
  </div>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
