<?php require_once('Connections/local.php'); ?>
<?php


if ($_GET['id_usuario']==""){
$corta=explode("#",$_GET['nombresx']);
$_GET['id_usuario']=$corta[1];}


if($_GET['id_usuario']=="") {
 $urlx="consulta.php?error=1";
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
$query_usuarios = "SELECT * FROM usuarios WHERE id_usuario = '".$_GET['id_usuario']."'";
$usuarios = mysql_query($query_usuarios, $local) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

$colname_propias = "-1";
if (isset($_GET['id_usuario'])) {
  $colname_propias = (get_magic_quotes_gpc()) ? $_GET['id_usuario'] : addslashes($_GET['id_usuario']);
}
mysql_select_db($database_local, $local);
$query_propias = sprintf("SELECT * FROM transacciones WHERE usuario_id = '%s' order by id_transaccion desc", $colname_propias);
$propias = mysql_query($query_propias, $local) or die(mysql_error());
$row_propias = mysql_fetch_assoc($propias);
$totalRows_propias = mysql_num_rows($propias);

mysql_select_db($database_local, $local);
$query_propias2 = sprintf("SELECT * FROM transacciones WHERE referido_por = '%s'  order by id_transaccion desc", $colname_propias);
$propias2 = mysql_query($query_propias2, $local) or die(mysql_error());
$row_propias2 = mysql_fetch_assoc($propias2);
$totalRows_propias2 = mysql_num_rows($propias2);

mysql_select_db($database_local, $local);
$query_creditos = "SELECT sum(monto) as credito FROM transacciones WHERE usuario_id =".$_GET['id_usuario']." OR referido_por =".$_GET['id_usuario'];
$creditos = mysql_query($query_creditos, $local) or die(mysql_error());
$row_creditos = mysql_fetch_assoc($creditos);
$totalRows_creditos = mysql_num_rows($creditos);

mysql_select_db($database_local, $local);
$query_creditos2 = "SELECT sum(monto) as credito FROM transacciones WHERE usuario_id =".$_GET['id_usuario'];
$creditos2 = mysql_query($query_creditos2, $local) or die(mysql_error());
$row_creditos2 = mysql_fetch_assoc($creditos2);
$totalRows_creditos2 = mysql_num_rows($creditos2);

mysql_select_db($database_local, $local);
$query_creditos3 = "SELECT sum(monto) as credito FROM transacciones WHERE referido_por =".$_GET['id_usuario'];
$creditos3 = mysql_query($query_creditos3, $local) or die(mysql_error());
$row_creditos3 = mysql_fetch_assoc($creditos3);
$totalRows_creditos3 = mysql_num_rows($creditos3);

mysql_select_db($database_local, $local);
$query_creditos_disponibles = "SELECT sum(creditos) FROM creditos WHERE empresa_id ='".$_SESSION['MM_UserGroup']."'";
$creditos_disponibles = mysql_query($query_creditos_disponibles, $local) or die(mysql_error());
$row_creditos_disponibles = mysql_fetch_assoc($creditos_disponibles);
$totalRows_creditos_disponibles = mysql_num_rows($creditos_disponibles);

?>

<!DOCTYPE html> 
<html> 
<head> 
	<title>tured.com</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="js/jquery.mobile-1.2.1.css" />
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.mobile-1.2.1.js"></script>
   
    

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
	<a href="logout.php" data-icon="delete"  rel="external" >Salir</a>
	<h1>TuRed.com</h1>
	<a href="micuenta.php" data-icon="gear"  rel="external">Mi Cuenta</a>
<div class="ui-body-d ui-body">
<div data-role="navbar" class="nav-glyphish-example" data-grid="d" >
	<ul>
    		<li><a href="compras.php" id="chat" data-icon="custom"  rel="external">Registrar Compra</a></li>
			<li><a href="consulta.php" id="email" data-icon="custom" class="ui-btn-active ui-state-persist" rel="external">Consultas</a></li>
			<li><a href="reporte.php" id="skull" data-icon="custom"   rel="external">Reportes</a></li>
			<li><a href="campanas.php" id="beer" data-icon="custom"  rel="external">Campañas</a></li>
			<li><a href="creditos.php" id="coffee" data-icon="custom"  rel="external">Créditos(<?php echo $row_creditos_disponibles['sum(creditos)']; ?>)</a></li>
	</ul>
</div>
 
</div></div>

<div data-role="content">	
<fieldset class="ui-grid-a">
	<div class="ui-block-a"><h1><?php echo $row_usuarios['nombres']; ?><br>
	  Bonos Disponibles:<?php echo number_format($row_creditos['credito'],2,",",".")." Bs"; ?></h1></div>
	<div class="ui-block-b"><a href="compras2.php?bono=<?php echo $row_creditos['credito']; ?>&id_usuario=<?php echo $_GET['id_usuario']; ?>&empresa_id=<?php echo $_SESSION['MM_UserGroup']; ?>" data-role="button"  data-theme="a" rel="external">Utilizar Bonos</a></div>
	<div class="ui-block-b"><a href="actualizar_cliente.php?id_usuario=<?php echo $_GET['id_usuario']; ?>&nombresx=<?php echo $_GET['nombresx']; ?>" data-role="button"  data-theme="b" rel="external">Editar Datos del Cliente</a></div>
	<p>&nbsp;</p>	   
</fieldset>

<div class="ui-body-c ui-body" >   
  <div data-role="collapsible" data-theme="d" >
   <h3>Bonos Por Transacciones Propias (<?php echo number_format($row_creditos2['credito'],2,",",".")." Bs"; ?>)</h3>
   	<ul data-role="listview" data-inset="true">
				<?php do { ?><li <?php if($row_propias['monto']<0) {echo "data-theme=\"a\""; echo "data-icon=\"alert\"";} ?>><a href="#"><?php echo $row_propias['fecha'];?> - #Factura:<?php echo $row_propias['factura']; ?><br> Tipo Operacion:<?php echo $row_propias['tipo']; ?><span class="ui-li-count">Monto del bono: <?php echo number_format($row_propias['monto'],2,",","."); ?> Bs</span></a></li>
				 <?php } while ($row_propias = mysql_fetch_assoc($propias)); ?>
    </ul>
    </div>
</div>
<div class="ui-body-c ui-body" >   
  <div data-role="collapsible" data-theme="e" >
   <h3>Bonos por Referidos  (<?php echo number_format($row_creditos3['credito'],2,",",".")." Bs"; ?>)</h3>
   <ul data-role="listview" data-inset="true">
				<?php do { ?><li><a href="#"><?php echo $row_propias2['fecha'];?> - #Factura:<?php echo $row_propias2['factura']; ?><span class="ui-li-count">Monto del bono por referido: <?php echo number_format($row_propias2['monto'],2,",","."); ?> Bs</span></a></li>
				 <?php } while ($row_propias2 = mysql_fetch_assoc($propias2)); ?>
    </ul></div>
</div>
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

mysql_free_result($propias);

mysql_free_result($creditos);
?>