<?php require_once('Connections/local.php'); ?>
<?php
 

mysql_select_db($database_local, $local);
$query_Recordset1 = "SELECT SUM(monto) as bonos,empresas.empresa_nombre as empresa ,usuarios.nombres,MAX(usuarios.telf) AS telefono  FROM transacciones,empresas,usuarios WHERE usuarios.ci='".$_GET['cedula']."' AND transacciones.empresa_id=empresas.empresa_id AND transacciones.usuario_id=usuarios.id_usuario GROUP BY transacciones.empresa_id";
$Recordset1 = mysql_query($query_Recordset1, $local) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

        
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
    $phoneNoRecip=$row_Recordset1['telefono'];
	$mensaje="";
    do {  $mensaje="Empresa:".$row_Recordset1['empresa']."- Bs ".$row_Recordset1['bonos'].".   ".$mensaje;   } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));  
	$msgText="Tu saldo es el siguiente:       ".$mensaje;
	
$i=SendSMS($host, $port, $username, $password, $phoneNoRecip, $msgText);
 
echo $msgText;

?>
  Saldo enviado