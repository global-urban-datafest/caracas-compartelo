<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="5" > 
<title>Estatus Plataforma</title>
</head>

<body>

<?php 
$xmlstr="http://200.75.136.182:8800/admin/xmlstatus?user=developer&password=developer";



function URLopen($url)
{
        // Fake the browser type
        ini_set('user_agent','MSIE 4\.0b2;');

        $dh = fopen("$url",'r');
        $result = fread($dh,8192);                                                                                                                            
        return $result;
} 

$returned=URLopen($xmlstr);
 
$mensajes_hoy=explode("<MessagesToday>",$returned);
$mensajes_hoy=explode("</MessagesToday>",$mensajes_hoy[1]);
echo "Mensajes Enviados hoy:".$mensajes_hoy[0]."<br>";

$mensajes_mes=explode("<MessagesLast30Days>",$returned);
$mensajes_mes=explode("</MessagesLast30Days>",$mensajes_mes[1]);
echo "Mensajes Enviados en el mes:".$mensajes_mes[0]."<br>";

 

$mensajes_encola=explode("<SMSOUTQ>",$returned);
$mensajes_encola=explode("</SMSOUTQ>",$mensajes_encola[1]);
echo "Mensajes En cola de env&iacute;o:".$mensajes_encola[0]."<br>";


$status_plataforma=explode("<MessagesToday>",$returned);
$mensajes_encola=explode("<Status>",$status_plataforma[0]);
echo "Estado de la Plataforma:".$status_plataforma[0]."<br>";

?> 
 
</body>
</html>