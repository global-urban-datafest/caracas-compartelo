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
?>
<?php

$cantidad_sms=0;

mysql_select_db($database_local, $local);
$query_Recordset1 = "SELECT * FROM usuarios WHERE id_usuario ='".$_GET['id_usuario']."'";
$Recordset1 = mysql_query($query_Recordset1, $local) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if($_GET['referido_por']<>"")
{ 
mysql_select_db($database_local, $local);
$query_Recordset2 = "SELECT * FROM usuarios WHERE id_usuario ='".$_GET['referido_por']."'";
$Recordset2 = mysql_query($query_Recordset2, $local) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

}
mysql_select_db($database_local, $local);
$query_empresas = "SELECT * FROM empresas WHERE empresa_id='".$_GET['empresa_id']."'";
$empresas = mysql_query($query_empresas, $local) or die(mysql_error());
$row_empresas = mysql_fetch_assoc($empresas);
$totalRows_empresas = mysql_num_rows($empresas);
$hora=date("H:i:s");
$fecha=date("d/m/Y");
$dia=date("N");

if($_GET['bono']=="") 
{$nuevo_monto=$_GET['monto']*0.08;
$insertSQL = "insert into transacciones (hora,fecha,empresa_id,usuario_id,factura,monto,vendedor_id,referido_por,tipo,dia) values ('".$hora."','".$fecha."','".$_SESSION['MM_UserGroup']."','".$_GET['id_usuario']."','".$_GET['factura']."','".$nuevo_monto."','".$_SESSION['vendedor_id']."','".$_GET['referido_por']."','Compra Directa','".$dia."')";
 mysql_select_db($database_local, $local);
  $Result1 = mysql_query($insertSQL, $local) or die(mysql_error());
  

  } 
else
{if($_GET['monto']>$_GET['bono'])
{
$resto=($_GET['monto']-$_GET['bono'])*0.08;


$insertSQL = "insert into transacciones (hora,fecha,empresa_id,usuario_id,factura,monto,vendedor_id,referido_por,tipo,dia) values ('".$hora."','".$fecha."','".$_SESSION['MM_UserGroup']."','".$_GET['id_usuario']."','".$_GET['factura']."','".$resto."','".$_SESSION['vendedor_id']."','".$_GET['referido_por']."','Compra Directa','".$dia."')";
 mysql_select_db($database_local, $local);
  $Result1 = mysql_query($insertSQL, $local) or die(mysql_error());
$menos=$_GET['bono']*(-1);

$insertSQL = "insert into transacciones (hora,fecha,empresa_id,usuario_id,factura,monto,vendedor_id,referido_por,tipo,dia) values ('".$hora."','".$fecha."','".$_SESSION['MM_UserGroup']."','".$_GET['id_usuario']."','".$_GET['factura']."','".$menos."','".$_SESSION['vendedor_id']."','".$_GET['referido_por']."','bono','".$dia."')";
 mysql_select_db($database_local, $local);
  $Result1 = mysql_query($insertSQL, $local) or die(mysql_error());



}
else
{
$menos=$_GET['monto']*(-1);
$insertSQL = "insert into transacciones (hora,fecha,empresa_id,usuario_id,factura,monto,vendedor_id,referido_por,tipo,dia) values ('".$hora."','".$fecha."','".$_SESSION['MM_UserGroup']."','".$_GET['id_usuario']."','".$_GET['factura']."','".$menos."','".$_SESSION['vendedor_id']."','".$_GET['referido_por']."','bono','".$dia."')";
 mysql_select_db($database_local, $local);
$Result1 = mysql_query($insertSQL, $local) or die(mysql_error());

$_GET['bono']=$_GET['monto'];
}


}
    


if($resto<>"") {$nuevo_monto=$resto;}	
	
  if($_GET['referido_por']=="")
{$mensaje="Gracias por Tu Compra! Acabas de Ganar un Bono de ".$nuevo_monto."Bs para tu proxima visita a ".$row_empresas['empresa_nombre']." .+info:".$row_empresas['empresa_tel1'].". Feliz Dia. ";
$mensaje=urlencode($mensaje); 
$url="http://touchsms.com.ve/clientes/apicall-touch.php?texto=".$mensaje."&telf=".$row_Recordset1['telf']."&pass=developer&login=developer&id_cuenta=0&id_cuenta_hija=0";
$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1');
$result = curl_exec($handle);
curl_close($handle);
$cantidad_sms="-1";

}
else
{$mensaje="Gracias por Tu Compra! Acabas de Ganar un Bono de ".$nuevo_monto."Bs para tu proxima visita a ".$row_empresas['empresa_nombre'].".+info:".$row_empresas['empresa_tel1'].". Feliz Dia. ";
$mensaje=urlencode($mensaje); 
$url="http://touchsms.com.ve/clientes/apicall-touch.php?texto=".$mensaje."&telf=".$row_Recordset1['telf']."&pass=developer&login=developer&id_cuenta=0&id_cuenta_hija=0";
$handle = curl_init();

$handle = curl_init();

curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1');

$result = curl_exec($handle);

curl_close($handle);

//mensaje al fererido

$mensaje="Uno de tus amigos acaba de comprar en ".$row_empresas['empresa_nombre']." y acabas de Ganar un Bono de ".$nuevo_monto."Bs para tu proxima visita a ".$row_empresas['empresa_nombre'].".+info:".$row_empresas['empresa_tel1'].". Feliz Dia. ";
$mensaje=urlencode($mensaje); 
$url="http://touchsms.com.ve/clientes/apicall-touch.php?texto=".$mensaje."&telf=".$row_Recordset2['telf']."&pass=developer&login=developer&id_cuenta=0&id_cuenta_hija=0";
$handle = curl_init();

curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:13.0) Gecko/20100101 Firefox/13.0.1');

$result = curl_exec($handle);

curl_close($handle);
$cantidad_sms="-2";
 }
 
            
$resto=$resto/0.08;
$url="fin_compra.php?resto=".$resto."&bono=".$_GET['bono'];
$detalle_sms="Mensaje enviado a los telefonos:".$row_Recordset2['telf']."-".$row_Recordset1['telf'];
$insertCredito = "insert into creditos (creditos,fecha_in,empresa_id,descr,detalle) values ('".$cantidad_sms."','".$fecha."-".$hora."','".$_SESSION['MM_UserGroup']."','mensaje de compra','".$detalle_sms."')";
mysql_select_db($database_local, $local);
$Result2 = mysql_query($insertCredito, $local) or die(mysql_error());



 
header("Location: $url");
 

?>