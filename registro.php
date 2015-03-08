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

 $fecha=date("d/m/Y h:i:s");
 $insertSQL = "INSERT INTO mensajes_in (mensaje, numero, fecha) VALUES ('".$_GET['texto']."','".$_GET['numero']."','".$fecha."')";
 mysql_select_db($database_local, $local);
 $Result1 = mysql_query($insertSQL, $local) or die(mysql_error());

function limpiahtml($codigo){
    $buscar = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
    $reemplazar = array('>','<','\\1');
    $codigo = preg_replace($buscar, $reemplazar, $codigo);
    $codigo = str_replace("> <", "><", $codigo);
    return $codigo;
}


  $MM_dupKeyRedirect="registro_cliente.php?error=1";
  $loginUsername =$_GET['texto'];
  $LoginRS__query ="SELECT ci FROM usuarios  WHERE ci='".$_GET['texto']."' AND empresa_id='".$_SESSION['MM_UserGroup']."'";
  mysql_select_db($database_local, $local);
  $LoginRS=mysql_query($LoginRS__query, $local) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }


$nac = "V";
$cedula =$_GET['texto'];
// Consulto la cedula con el recurso de la pagina del CNE
$url="http://www.cne.gov.ve/web/registro_electoral/ce.php?nacionalidad=$nac&cedula=$cedula";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // almacene en una variable
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$xxx1 = curl_exec($ch);
curl_close($ch);
$xxx = explode(" ", $xxx1);

$datos1 = explode(":", $xxx1);


$datosx=$datos1[10].$datos1[11].$datos1[12].$datos1[13];
$datosx = explode("<strong>", $datosx);
$datosy=$datosx[0].$datosx[1].$datosx[2].$datosx[3];
$nombre_raro= strip_tags(limpiahtml($datosy));

$nombre_raro=str_replace("Segundo Nombre","",$nombre_raro);
$nombre_raro=str_replace("Primer Apellido","",$nombre_raro);
$nombre_raro=str_replace("Segundo Apellido","",$nombre_raro);
$nombre_normal=strip_tags(limpiahtml($datosx[0]));
if($nombre_raro==$nombre_normal) {;

$nombre_normal2=explode("Estado",$nombre_normal);
$estado=explode("Municipio",$nombre_normal2[1]);
$nombres=$nombre_normal2[0];
$estado=$estado[0];}
else
{$nombres=$nombre_raro; $estado="";}


$valida=strlen($nombres);
if ($valida>100) {$nombres=""; $estado="";$statuscne=0;} else { $statuscne=1;}

if($statuscne==1){
$mensaje=$nombres.", Gracias por unirte a la red de Matrimonios Felices, por tu afiliación  acumulaste  20 puntos en premios.";
$mensaje=urlencode($mensaje);
$url="http://touchsms.com.ve/clientes/apicall-touch.php?texto=".$mensaje."&telf=".$_GET['numero']."&pass=developer&login=developer&id_cuenta=0&id_cuenta_hija=0";

$handle = curl_init();

curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1');

$result = curl_exec($handle);


curl_close($handle);


$insertSQL = "INSERT INTO usuarios (nombres, ci, telf,estado,fecha_in,empresa_id) VALUES ('".$nombres."','".$cedula."','".$_GET['numero']."','".$estado."','".$fecha."','".$_SESSION['MM_UserGroup']."')";
 mysql_select_db($database_local, $local);
 $Result1 = mysql_query($insertSQL, $local) or die(mysql_error());
if($_GET['viene']=="")
{
header("Location: compras.php?registrado=1");}
else
{header("Location: compras_referida.php?registrado=1");}
}
else

{
	$url2="registro_especial.php?cedula=".$cedula."&telf=".$_GET['numero'];
header("Location: $url2");
}
?>
 