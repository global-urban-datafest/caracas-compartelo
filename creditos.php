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
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

mysql_select_db($database_local, $local);
$query_usuarios = "SELECT * FROM usuarios where empresa_id='".$_SESSION['MM_UserGroup']."'";
$usuarios = mysql_query($query_usuarios, $local) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

$colname_creditos_disponibles = "-1";
if (isset($_SESSION['MM_UserGroup'])) {
  $colname_creditos_disponibles = $_SESSION['MM_UserGroup'];
}
mysql_select_db($database_local, $local);
$query_creditos_disponibles = sprintf("SELECT sum(creditos) FROM creditos WHERE empresa_id = %s", GetSQLValueString($colname_creditos_disponibles, "text"));
$creditos_disponibles = mysql_query($query_creditos_disponibles, $local) or die(mysql_error());
$row_creditos_disponibles = mysql_fetch_assoc($creditos_disponibles);
$totalRows_creditos_disponibles = mysql_num_rows($creditos_disponibles);

$maxRows_creditos_detail = 10;
$pageNum_creditos_detail = 0;
if (isset($_GET['pageNum_creditos_detail'])) {
  $pageNum_creditos_detail = $_GET['pageNum_creditos_detail'];
}
$startRow_creditos_detail = $pageNum_creditos_detail * $maxRows_creditos_detail;

$colname_creditos_detail = "-1";
if (isset($_SESSION['MM_UserGroup'])) {
  $colname_creditos_detail = $_SESSION['MM_UserGroup'];
}
mysql_select_db($database_local, $local);
$query_creditos_detail = sprintf("SELECT * FROM creditos WHERE empresa_id = %s ORDER BY id_credito DESC", GetSQLValueString($colname_creditos_detail, "text"));
$query_limit_creditos_detail = sprintf("%s LIMIT %d, %d", $query_creditos_detail, $startRow_creditos_detail, $maxRows_creditos_detail);
$creditos_detail = mysql_query($query_limit_creditos_detail, $local) or die(mysql_error());
$row_creditos_detail = mysql_fetch_assoc($creditos_detail);

if (isset($_GET['totalRows_creditos_detail'])) {
  $totalRows_creditos_detail = $_GET['totalRows_creditos_detail'];
} else {
  $all_creditos_detail = mysql_query($query_creditos_detail);
  $totalRows_creditos_detail = mysql_num_rows($all_creditos_detail);
}
$totalPages_creditos_detail = ceil($totalRows_creditos_detail/$maxRows_creditos_detail)-1;

$queryString_creditos_detail = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_creditos_detail") == false && 
        stristr($param, "totalRows_creditos_detail") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_creditos_detail = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_creditos_detail = sprintf("&totalRows_creditos_detail=%d%s", $totalRows_creditos_detail, $queryString_creditos_detail);
?><!DOCTYPE html> 
<html> 
<head> 
		<title>tured.com</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="js/jquery.mobile-1.2.1.css" />
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.mobile-1.2.1.js"></script>
  
		<script src="Demos/js/jquery-1.9.1.min.js"></script>
		<script src="Demos/js/knockout-2.2.1.js"></script>
		<script src="Demos/js/globalize.min.js"></script>
		<script src="Demos/js/dx.chartjs.js"></script>
  
    

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
    <style type="text/css" media="all">
    /* fix rtl for demo */
    .chosen-rtl .chosen-drop { left: -9000px; }
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
    		<li><a href="compras.php" id="chat" data-icon="custom"  rel="external">Registrar Compra</a></li>
			<li><a href="consulta.php" id="email" data-icon="custom"  rel="external">Consultas</a></li>
			<li><a href="reporte.php" id="skull" data-icon="custom"  rel="external">Reportes</a></li>
			<li><a href="campanas.php" id="beer" data-icon="custom"  rel="external"  >Campañas</a></li>
			<li><a href="creditos.php" id="coffee" data-icon="custom" rel="external" class="ui-btn-active ui-state-persist">Créditos (<?php echo $row_creditos_disponibles['sum(creditos)']; ?>)</a></li>
	</ul>
</div>	
<iframe src="cuadro.php" frameborder="0" width="100%" height="350"></iframe>
		
 <div class="ui-body-d ui-body" >
<h1> Creditos disponibles: <?php echo $row_creditos_disponibles['sum(creditos)']; ?></h1><a href="cuentas.php" data-role="button" data-theme="b">Agregar Créditos</a>
 
			
				
				
<div data-role="collapsible-set">

	<div data-role="collapsible" data-collapsed="false">
	<h3>Ver Detalles de Créditos    </h3>
	<table border="0" align="center" cellpadding="1" cellspacing="1" class="ui-responsive table-stroke" id="my-table" data-role="table"  data-mode="columntoggle">
	 <thead> <tr>
        <th class="ui-bar-b">Créditos </td>
        <th class="ui-bar-b">Fecha Procesada</td>
        <th class="ui-bar-b">Tipo de Mensaje</td>
        <th class="ui-bar-b">Detalle</td>
      </tr>
      </thead>
      <?php do { ?>
        <tr>
          <td valign="middle" class="ui-body-c"><?php if($row_creditos_detail['creditos']<0) {?><img src="images/red.png" width="15" height="20"><?php } else  {?><img src="images/gree.png" width="15" height="20"> <?php } echo $row_creditos_detail['creditos']; ?></td>
          <td class="ui-body-c"><?php echo $row_creditos_detail['fecha_in']; ?></td>
          <td class="ui-body-c"><?php echo $row_creditos_detail['descr']; ?></td>
          <td class="ui-body-c"><?php echo $row_creditos_detail['detalle']; ?></td>
        </tr>
        <?php } while ($row_creditos_detail = mysql_fetch_assoc($creditos_detail)); ?>
  </table>
	
	</div>
	
	
	
</div>
	

</div><!-- /content -->

<div data-role="footer" class="footer-docs" data-theme="b" align="center">
		<p class="jqm-version"></p>
		<p>tured.com 2013</p>
  </div>
</div>

<!-- /page -->



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
  <script src="chosen.jquery.js" type="text/javascript"></script>
  <script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
</body>
</html>
<?php
mysql_free_result($usuarios);

mysql_free_result($creditos_disponibles);

mysql_free_result($creditos_detail);
?>