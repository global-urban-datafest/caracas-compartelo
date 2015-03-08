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

mysql_select_db($database_local, $local);
$query_cuenta_empresas = "SELECT COUNT(*) AS total, CONCAT(SUBSTR(empresas_fecha_in,4,2),'/',SUBSTR(empresas_fecha_in,7,4)) AS mes  FROM empresas GROUP BY mes";
$cuenta_empresas = mysql_query($query_cuenta_empresas, $local) or die(mysql_error());
$row_cuenta_empresas = mysql_fetch_assoc($cuenta_empresas);
$totalRows_cuenta_empresas = mysql_num_rows($cuenta_empresas);



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
<body> 
<script type="text/javascript">
			$(function ()  
				{
   var dataSource = [
    { year: 'Enero', smp: 263, mmp: 226, cnstl: 10 },
    { year: 1999, smp: 169, mmp: 256, cnstl: 66 },
    { year: 2001, smp: 57, mmp: 257, cnstl: 143 },
    { year: 2003, smp: 0, mmp: 163, cnstl: 127 },
    { year: 2005, smp: 0, mmp: 103, cnstl: 36 },
    { year: 2007, smp: 0, mmp: 91, cnstl: 3 }
];

$("#chartContainer").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        type: "spline",
        argumentField: "year"
    },
    commonAxisSettings: {
        grid: {
            visible: true
        }
    },
    series: [
        { valueField: "smp", name: "Empresas" },
        { valueField: "mmp", name: "Clientes" },
        { valueField: "cnstl", name: "Mensajes" }
    ],
    tooltip:{
        enabled: true
    },
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    title: "Empresas - Clientes ",
    commonPaneSettings: {
        border:{
            visible: true,
            bottom: false
        }
    }
});
}

			);
		</script>
		
 <script type="text/javascript">
			$(function ()  
				{
   var dataSource = [
    { state: "Hoy", young: <?php  $mensajes_hoy=explode("<MessagesToday>",$returned);$mensajes_hoy=explode("</MessagesToday>",$mensajes_hoy[1]);echo $mensajes_hoy[0];?>, middle: <?php $mensajes_encola=explode("<SMSOUTQ>",$returned); $mensajes_encola=explode("</SMSOUTQ>",$mensajes_encola[1]); echo $mensajes_encola[0];?> },
    { state: "En la Semana", young: <?php  $mensajes_semana=explode("<MessagesLast7Days>",$returned);$mensajes_semana=explode("</MessagesLast7Days>",$mensajes_semana[1]);echo $mensajes_semana[0]; ?>, middle: 0 },
    { state: "En el Mes", young: <?php $mensajes_mes=explode("<MessagesLast30Days>",$returned);$mensajes_mes=explode("</MessagesLast30Days>",$mensajes_mes[1]);echo $mensajes_mes[0];?>, middle: 0 } 
];

$("#chartContainer2").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "state",
        type: "stackedBar"
    },
    series: [
        { valueField: "young", name: "SMS Enviados" },
        { valueField: "middle", name: "SMS En Cola" }
    ],
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    valueAxis: {
        title: {
            text: "SMS"
        },
        position: "right"
    },
    title: "Mensajes Enviados",
    tooltip: {
        enabled: true,
        customizeText: function () {
            return this.seriesName + ": " + this.valueText;
        }
    }
});
}

			);
		</script>

<script type="text/javascript">
			$(function ()  
				{
   var dataSource = [
  { country: "USA", gold: 36, silver: 38, bronze: 36 },
  { country: "China", gold: 51, silver: 21, bronze: 28 },
  { country: "Russia", gold: 23, silver: 21, bronze: 28 },
  { country: "Britain", gold: 19, silver: 13, bronze: 15 },
  { country: "Australia", gold: 14, silver: 15, bronze: 17 },
  { country: "Germany", gold: 16, silver: 10, bronze: 15 }
];

$("#chartContainer3").dxChart({
    rotated: true,
    pointSelectionMode: "multiple",
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "country",
        type: "stackedbar",
        selectionStyle: {
            hatching: "left"
        }
    },
    series: [
      { valueField: "gold", name: "SMS de Campañas", color: "gold" },
      { valueField: "silver", name: "SMS de Compras", color: "green" }
    ],
    title: {
        text: "Mensajes por Empresas - Mes: <?php echo date("m/Y");?>"
    },
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    pointClick: function(point) {
        point.fullState & 2 ? point.clearSelection() : point.select();
    }
});
}

			);
		</script>
<!-- Start of first page: #one -->
<div data-role="page">
 

	<div data-role="header" data-theme="e">
	<a href="logout.php" data-icon="delete"  rel="external">Salir</a>
	<h1>TuRed.com - Panel de Administraci&oacute;n</h1>
	
<div class="ui-body-d ui-body">
<div data-role="navbar" class="nav-glyphish-example" data-grid="c" >
	<ul>
			<li><a href="admin_empresa.php" id="email" data-icon="custom"  rel="external"  >Empresas</a></li>
			<li><a href="admin_cuentas.php" id="skull" data-icon="custom"  rel="external"  >Cuentas</a></li>
			<li><a href="admin_creditos.php" id="beer" data-icon="custom"  rel="external">Agregar Creditos</a></li>
			<li><a href="admin_reportes.php" id="coffee" data-icon="custom" rel="external" class="ui-btn-active ui-state-persist">Reportes</a></li>
	</ul>
</div>
 <div class="ui-body-d ui-body" >
</div><!-- /navbar -->
</div></div>

<div data-role="content">
  <div class="ui-body-c">
    <h3>Cuadro de Mando - Empresas</h3>
    
    <div class="ui-grid-a" align="center">
      <div class="ui-block-a">
        <div id="chartContainer" style="width: 100%; height: 440px;"></div>   </div>
        <div class="ui-block-b">
         
      <div id="chartContainer2" style="width: 100%; height: 440px;"></div>
    </div>
  </div>
 
   <div class="ui-body-e ui-body" >
    <div id="chartContainer3" style="width: 100%; height: 440px;"></div>
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
mysql_free_result($cuenta_empresas);
?>
