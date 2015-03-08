<?php
function limpiahtml($codigo){
    $buscar = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
    $reemplazar = array('>','<','\\1');
    $codigo = preg_replace($buscar, $reemplazar, $codigo);
    $codigo = str_replace("> <", "><", $codigo);
    return $codigo;
}

$nac = "V";
$cedula =$_GET['cedula'];
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

echo $valida;
if ($valida>100) {$nombres=""; $estado="";$statuscne=0;} else { $statuscne=1;}


?>