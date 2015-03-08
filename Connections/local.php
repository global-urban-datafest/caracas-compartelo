<?php

//$url="200.75.136.182:8800";
//$handle = curl_init($url);
//curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

/* Get the HTML or whatever is linked in $url. */
//$response = curl_exec($handle);
 
//$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
//if($httpCode==0) {
//	$urlmantenimiento="mantenimiento.php?error=5";
//	header("Location: ". $urlmantenimiento); } 

//curl_close($handle);

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_local = "192.168.6.116";
$database_local = "tured";
$username_local = "dale";
$password_local = "123456";
$local = mysql_connect($hostname_local, $username_local, $password_local) or trigger_error(mysql_error(),E_USER_ERROR); 
?>