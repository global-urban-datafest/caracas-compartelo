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

mysql_select_db($database_local, $local);
$query_usuarios = "SELECT * FROM usuarios where empresa_id='".$_SESSION['MM_UserGroup']."'";
$usuarios = mysql_query($query_usuarios, $local) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

mysql_select_db($database_local, $local);
$query_creditos_disponibles = "SELECT sum(creditos) FROM creditos WHERE empresa_id ='".$_SESSION['MM_UserGroup']."'";
$creditos_disponibles = mysql_query($query_creditos_disponibles, $local) or die(mysql_error());
$row_creditos_disponibles = mysql_fetch_assoc($creditos_disponibles);
$totalRows_creditos_disponibles = mysql_num_rows($creditos_disponibles);
?><!DOCTYPE html> 
<html> 
<head> 
	<title>tured.com</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="js/jquery.mobile-1.2.1.css" />
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.mobile-1.2.1.js"></script>
    <script src="jquery.validate.js"></script>
	<script src="main.js"></script>
    
   
    

</head> 

<style>	
		.nav-glyphish-example .ui-btn .ui-btn-inner { padding-top: 40px !important; }
		.nav-glyphish-example .ui-btn .ui-icon { width: 30px!important; height: 30px!important; margin-left: -15px !important; box-shadow: none!important; -moz-box-shadow: none!important; -webkit-box-shadow: none!important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
		#chat .ui-icon { background:  url(glyphish-icons/119-piggy-bank.png) 50% 50% no-repeat; }
		#email .ui-icon { background:  url(glyphish-icons/06-magnify.png) 50% 50% no-repeat;}
		#login .ui-icon { background:  url(glyphish-icons/30-key.png) 50% 50% no-repeat; }
		#beer .ui-icon { background:  url(glyphish-icons/139-flags.png) 50% 50% no-repeat; }
		#coffee .ui-icon { background:  url(glyphish-icons/192-credit-card.png) 50% 50% no-repeat;}
		#skull .ui-icon { background:  url(glyphish-icons/17-bar-chart.png) 50% 50% no-repeat; }
	</style>
<body> 
<!-- Start of first page: #one -->
<div data-role="page" id="registerPage">

	<div data-role="header">
	<a href="logout.php" data-icon="delete"  rel="external">Salir</a>
	<h1>TuRed.com</h1>
	<a href="micuenta.php" data-icon="gear"  rel="external">Mi Cuenta</a>
<div class="ui-body-d ui-body">
<div data-role="navbar" class="nav-glyphish-example" data-grid="d" >
	<ul>
    		<li><a href="compras.php" id="chat" data-icon="custom"  rel="external">Registrar Compra</a></li>
			<li><a href="consulta.php" id="email" data-icon="custom"  rel="external">Consultas</a></li>
			<li><a href="reporte.php" id="skull" data-icon="custom"  rel="external">Reportes</a></li>
			<li><a href="campanas.php" id="beer" data-icon="custom"  rel="external" class="ui-btn-active ui-state-persist" >Campañas</a></li>
			<li><a href="creditos.php" id="coffee" data-icon="custom" rel="external">Créditos(<?php echo $row_creditos_disponibles['sum(creditos)']; ?>)</a></li>
	</ul>
</div>
 <div class="ui-body-d ui-body" >
<div data-role="navbar"   data-theme="b" >
	<ul>
    		<li><a href="campanas.php"  rel="external">Mensaje Masivo (SMS)</a></li>
			<li><a href="mensajes_seleccionados.php" rel="external"  >Mensaje a Seleccionados</a></li>
            <li><a href="import.php" rel="external" class="ui-btn-active ui-state-persist"  >Importar Base de Datos de Clientes</a></li>
			 
	</ul>
</div></div><!-- /navbar -->
</div></div>

<div data-role="content">	
<h3>Vista Previa de los contactos cargados.</h3>
 
<ol data-role="listview" data-inset="true" data-filter="true" data-theme="a">
<?php 
$cuentax=0;
 function limpiahtml($codigo){
    $buscar = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
    $reemplazar = array('>','<','\\1');
    $codigo = preg_replace($buscar, $reemplazar, $codigo);
    $codigo = str_replace("> <", "><", $codigo);
    return $codigo;
}

$cuenta=-1;
if ($_FILES[csv][size] > 0) {
 
	
	if($_FILES[csv][type]=="text/plain") {
  
    //get the csv file
    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");
    
    //loop through the csv file and insert into database
    do {
      

$nac = substr($data[0],0,1);
$cedula =substr($data[0],1,11);
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
if ($valida>100) {$nombres=""; $estado="";$statuscne=0;} else { if ($data[1]=="") {$uyq=0;} else {$cuentax=$cuentax+1; $statuscne=1;echo "<li>ci:".$cedula." ".$nombres." - ".$data[1]."</li>
 ";  
 $fecha=date("d/m/y");
 $_SESSION['query'][$cuentax]="('".$nombres."','".$cedula."','".$data[1]."','".$estado."','".$fecha."','".$_SESSION['MM_UserGroup']."');";
 
 }}
 
 $cuenta=$cuenta+1;    
       
    } while ($data = fgetcsv($handle,10000000,",","'"));
	

    //
	}
	
	else { echo "formato no aceptado";}
 

}


?>

</ol>
	
<?php echo "<br>Total de Registros:".$cuentax; ?> (Registros inválidos <?php echo $cuenta-$cuentax;?>)
 <a href="importa_do.php" data-role="button" rel="external">Confirmar, Importar Clientes</a> 
</div><!-- /content -->

<div data-role="footer" class="footer-docs" data-theme="b" align="center">
		<p class="jqm-version"></p>
		<p>tured.com 2013</p>
  </div>
</div>

<!-- /page -->




</body>
</html>
<?php
mysql_free_result($usuarios);
?>


