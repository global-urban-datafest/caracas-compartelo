<?php require_once('Connections/local.php'); ?>
<?php

if ($_GET['id_usuario']==""){
$corta=explode("#",$_GET['nombresx']);
$_GET['id_usuario']=$corta[1];}


$corta=explode("#",$_GET['nombresx2']);
$_GET['referido_por']=$corta[1];

if($_GET['id_usuario']=="") {
 $urlx="compras_referida.php?error=1";
header("Location: $urlx");}


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
mysql_select_db($database_local, $local);
$query_usuarios = "SELECT * FROM usuarios where empresa_id='".$_SESSION['MM_UserGroup']."'";
$usuarios = mysql_query($query_usuarios, $local) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);
?><!DOCTYPE html> 
<html> 
<head> 
	<title>tured.com</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="js/jquery.mobile-1.2.1.css" />
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.mobile-1.2.1.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
   
    
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
<div data-role="page">

	<div data-role="header">
	<a href="logout.php" data-icon="delete"  rel="external">Salir</a>
	<h1>TuRed.com</h1>
	<a href="micuenta.php" data-icon="gear"  rel="external">Mi Cuenta</a>
<div class="ui-body-d ui-body">
<div data-role="navbar" class="nav-glyphish-example" data-grid="d" >
	<ul>
    		<li><a href="compras.php" id="chat" data-icon="custom" class="ui-btn-active ui-state-persist"  rel="external">Registrar Compra</a></li>
			<li><a href="consulta.php" id="email" data-icon="custom"  rel="external">Consultas</a></li>
			<li><a href="reporte.php" id="skull" data-icon="custom"  rel="external">Reportes</a></li>
			<li><a href="campanas.php" id="beer" data-icon="custom"  rel="external">Campañas</a></li>
			<li><a href="creditos.php" id="coffee" data-icon="custom" rel="external">Créditos</a></li>
	</ul>
</div>
 <div class="ui-body-d ui-body" >
<div data-role="navbar"  data-grid="a" data-theme="b" >
	<ul>
    		<li><a href="compras.php"  rel="external">Registrar Compra Simple</a></li>
			<li><a href="compras_referida.php" rel="external"  class="ui-btn-active ui-state-persist" >Registrar Compra Referida</a></li>
			 
	</ul>
</div></div><!-- /navbar -->
</div></div>

<div data-role="content">	

<script>
$(function() {
var availableTags = [
<?php do { ?> "<?php echo $row_usuarios['nombres']; ?> <?php echo $row_usuarios['ci']; ?> <?php echo $row_usuarios['telf']; ?>  #<?php echo $row_usuarios['id_usuario']; ?>",
<?php } while ($row_usuarios = mysql_fetch_assoc($usuarios)); ?>" "

];
$( "#tags" ).autocomplete({
source: availableTags
});
});
</script>
<div>
<form action="compras2r.php" method="get"  data-ajax="false" class="ui-body ui-body-b ui-corner-all" id="registerForm"><h3>Paso 2:Quien refirio al Cliente?</h3>
<?php if ($_GET['error']==1) {echo "<h3>Verifique los datos del cliente!!!</h3>";}?>
<input id="tags" type="text" value="" name="nombresx2" placeholder="ingrese cualquier dato del cliente (nombre, apellido o cedula)..." /><br>
<input id="id_usuario" type="hidden" value="<?php echo $_GET['id_usuario']; ?>" name="id_usuario" placeholder="ingrese cualquier dato del cliente (nombre, apellido o cedula)..." />
<button type="submit" data-theme="b" name="submit" value="submit-value">Continuar</button>
</form>
<br>
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