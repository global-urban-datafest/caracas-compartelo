<?php require_once('Connections/local.php'); ?>
<?php

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


$mensaje=.$_GET['nombres'].", Gracias por unirte a la red de Matrimonios Felices, por tu afiliación  acumulaste  20 puntos en premios.";
$mensaje=urlencode($mensaje);
$url="http://touchsms.com.ve/clientes/apicall-touch.php?texto=".$mensaje."&telf=".$_GET['telf']."&pass=developer&login=developer&id_cuenta=0&id_cuenta_hija=0";

$handle = curl_init();

curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1');

$result = curl_exec($handle);


curl_close($handle);


$insertSQL = "INSERT INTO usuarios (nombres, ci, telf,estado,fecha_in,empresa_id) VALUES ('".$_GET['nombres']."','".$_GET['cedula']."','".$_GET['telf']."','".$estado."','".$fecha."','".$_SESSION['MM_UserGroup']."')";
 mysql_select_db($database_local, $local);
 $Result1 = mysql_query($insertSQL, $local) or die(mysql_error());

header("Location: compras.php");

?>
 