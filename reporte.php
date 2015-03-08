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

if($_SESSION['MM_Username']=="admin") {header("Location: admin_reportes.php"); }
mysql_select_db($database_local, $local);
$query_clientes = "SELECT * FROM usuarios where empresa_id='".$_SESSION['MM_UserGroup']."'";
$clientes = mysql_query($query_clientes, $local) or die(mysql_error());
$row_clientes = mysql_fetch_assoc($clientes);
$totalRows_clientes = mysql_num_rows($clientes);

mysql_select_db($database_local, $local);
$query_referidos = " SELECT count(*) as referidosc, usuario_id FROM transacciones WHERE usuario_id <> referido_por AND referido_por <> '' and empresa_id='".$_SESSION['MM_UserGroup']."' GROUP BY usuario_id ";
$referidos = mysql_query($query_referidos, $local) or die(mysql_error());
$row_referidos = mysql_fetch_assoc($referidos);
$totalRows_referidos = mysql_num_rows($referidos);

mysql_select_db($database_local, $local);
$query_ventasdiretas = "select sum(monto)/0.08 as vd,substr(fecha,4,2) as mes from transacciones where tipo='Compra Directa' and referido_por<>''and empresa_id='".$_SESSION['MM_UserGroup']."' group by mes ORDER BY mes DESC LIMIT 0,3";
$ventasdiretas = mysql_query($query_ventasdiretas, $local) or die(mysql_error());
$row_ventasdiretas = mysql_fetch_assoc($ventasdiretas);
$totalRows_ventasdiretas = mysql_num_rows($ventasdiretas); 

mysql_select_db($database_local, $local);
$query_ventas_referidas = "select sum(monto)/0.08 as vr,substr(fecha,4,2) as mes from transacciones where tipo='Compra Directa' and referido_por='' and empresa_id='".$_SESSION['MM_UserGroup']."' group by mes ORDER BY mes DESC LIMIT 0,3";
$ventas_referidas = mysql_query($query_ventas_referidas, $local) or die(mysql_error());
$row_ventas_referidas = mysql_fetch_assoc($ventas_referidas);
$totalRows_ventas_referidas = mysql_num_rows($ventas_referidas);

mysql_select_db($database_local, $local);
$query_ventas_dia = "select count(*) as ventas_dia, dia from transacciones where tipo='Compra Directa' and empresa_id='".$_SESSION['MM_UserGroup']."' group by dia order by dia asc";
$ventas_dia = mysql_query($query_ventas_dia, $local) or die(mysql_error());
$row_ventas_dia = mysql_fetch_assoc($ventas_dia);
$totalRows_ventas_dia = mysql_num_rows($ventas_dia);

mysql_select_db($database_local, $local);
$query_vips = "SELECT COUNT(*) AS cr , SUM(monto) AS ig , referido_por, nombres FROM transacciones,usuarios WHERE referido_por >0 AND tipo='Compra Directa' AND transacciones.empresa_id='".$_SESSION['MM_UserGroup']."' AND usuarios.id_usuario=transacciones.referido_por GROUP BY referido_por ORDER BY SUM(monto) DESC LIMIT 0 ,5 ";
$vips = mysql_query($query_vips, $local) or die(mysql_error());
$row_vips = mysql_fetch_assoc($vips);
$totalRows_vips = mysql_num_rows($vips);

mysql_select_db($database_local, $local);
$query_creditos_disponibles = "SELECT sum(creditos) FROM creditos WHERE empresa_id ='".$_SESSION['MM_UserGroup']."'";
$creditos_disponibles = mysql_query($query_creditos_disponibles, $local) or die(mysql_error());
$row_creditos_disponibles = mysql_fetch_assoc($creditos_disponibles);
$totalRows_creditos_disponibles = mysql_num_rows($creditos_disponibles);

mysql_select_db($database_local, $local);
$query_campanas = "SELECT COUNT(*) AS destinatarios ,MIN(fecha_in) AS fecha ,mensaje FROM creditos where empresa_id='".$_SESSION['MM_UserGroup']."' GROUP BY mensaje
";
$campanas = mysql_query($query_campanas, $local) or die(mysql_error());
$row_campanas = mysql_fetch_assoc($campanas);
$totalRows_campanas = mysql_num_rows($campanas);

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

  
<script type="text/javascript">
			$(function ()  
				{
   $("#chartContainer").dxCircularGauge({
	   title: "<?php echo $totalRows_clientes; ?> Clientes Afiliados",
    legend: {
        horizontalAlignment: "center",
        verticalAlignment: "middle",
        margin: 10
    },
	preset: "preset3",

	geometry: {
		radius: 360
	},

	scale: {
		label: {
			visible: true
		}
	},

	spindle: {
		visible: true
	},

	rangeContainer: {
		backgroundColor: "none"
	},

	commonRangeBarSettings: {
		size: 19,
		backgroundColor: "#F0F0F0"
	},
	

	rangeBars: [
		{ value: <?php echo ($totalRows_referidos/$totalRows_clientes)*100; ?>, offset: 50, color: "#A6C567", text: { indent: 30 } },
		{ value: <?php echo (($totalRows_clientes-$totalRows_referidos)/$totalRows_clientes)*100; ?>, offset: 70, color: "#679EC5", text: { indent: 50 } }
	]
});
}

			);
		</script>
 
       <script type="text/javascript">
			$(function ()  
				{
   var dataSource = [ <?php 

 if($row_ventasdiretas['mes']<$row_ventas_referidas['mes']) {$maximo=$row_ventas_referidas['mes']+0;} 
  if($row_ventasdiretas['mes']>=$row_ventas_referidas['mes']) {$maximo=$row_ventasdiretas['mes']+0;} 
 

  
  $i=0;$j=0;
  
  do {   
   	$valores[$i][$j]=$row_ventasdiretas['mes'];
    $j=$i+1;  
   	$valores[$i][$j]=$row_ventasdiretas['vd'];
    $i=$i+1;
   } while ($row_ventasdiretas = mysql_fetch_assoc($ventasdiretas)); 
   
    $i=0;$j=0;
  
  do {   
   	$valores2[$i][$j]=$row_ventas_referidas['mes'];
    $j=$i+1;  
   	$valores2[$i][$j]=$row_ventas_referidas['vr'];
    $i=$i+1;
   } while ($row_ventas_referidas = mysql_fetch_assoc($ventas_referidas)); 

$lar1=count($valores);
$lar2=count($valores2);
if($lar1>=$lar2) {$largo=$lar1;} else {$largo=$lar2;}

$k=0;
$m=0;
$p=0;
$t=0;
$puntero=0;

if ($valores2[$k][$m]<>$maximo)
{$valo1=0;}
else
{$m=$m+1;
$valo1=$valores2[$k][$m];
$k=$k+1;}

if ($valores[$p][$t]<>$maximo)
{$valo2=0;}
else
{$t=$t+1;
$valo2=$valores[$p][$t];
$p=$p+1;}

echo "{ state: \"mes ".$maximo."\", maleyoung: ".$valo1.", malemiddle: ".$valo2."}";
$maximo=$maximo-1;


if($largo>1)
{
if ($valores2[$k][$m]<>$maximo)
{$valo1=0;}
else
{$m=$m+1;
$valo1=$valores2[$k][$m];
$k=$k+1;}

if ($valores[$p][$t]<>$maximo)
{$valo1=0;}
else
{$t=$t+1;
$valo2=$valores[$p][$t];
$p=$p+1;}

echo ",{ state: \"mes ".$maximo."\", maleyoung: ".$valo1.", malemiddle: ".$valo2."}";
$maximo=$maximo-1;
}

$puntero=2;
if($largo>2)
{
if ($valores2[$k][$m]<>$maximo)
{$valo1=0;}
else
{$m=$m+1;
$valo1=$valores2[$k][$m];
$k=$k+1;}

if ($valores[$p][$t]<>$maximo)
{$valo1=0;}
else
{$t=$t+1;
$valo2=$valores[$p][$t];
$p=$p+1;}

echo ",{ state: \"mes ".$maximo."\", maleyoung: ".$valo1.", malemiddle: ".$valo2."}";

}


	
   ?>   
];

$("#chartContainerb1").dxChart({
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "state",
        type: "stackedBar"
    },
    series: [
        { valueField: "maleyoung", name: "Ventas Referidas", stack: "male" },
        { valueField: "malemiddle", name: "Ventas Directas", stack: "male" },
     
       
    ],
    legend: {
        horizontalAlignment: "right",
        position: "outside",
        border: { visible: true }
    },
   
 
   
});
}

			);
		</script>
        
    <script type="text/javascript">
			$(function ()  
				{
   $("#chartContainerb2").dxChart({
    dataSource: [
	        <?php do { ?>
             {day: "<?php if($row_ventas_dia['dia']==1) {echo "Lunes";};if($row_ventas_dia['dia']==2) {echo "Mar";};if($row_ventas_dia['dia']==3) {echo "Mier";};if($row_ventas_dia['dia']==4) {echo "Jue";};if($row_ventas_dia['dia']==5) {echo "Vie";};if($row_ventas_dia['dia']==6) {echo "Sab";};if($row_ventas_dia['dia']==7) {echo "Dom";} ?>", oranges: <?php echo $row_ventas_dia['ventas_dia']; ?>},
            <?php } while ($row_ventas_dia = mysql_fetch_assoc($ventas_dia)); ?>
        ],
 
    series: {
        argumentField: "day",
        valueField: "oranges",
        name: "Ventas por Día",
        type: "bar",
        color: "orange"
    }
});
}

			);
		</script>
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
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=146240422077010";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
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
			<li><a href="consulta.php" id="email" data-icon="custom"  rel="external">Consultas</a></li>
			<li><a href="reporte.php" id="skull" data-icon="custom" class="ui-btn-active ui-state-persist"  rel="external">Reportes</a></li>
			<li><a href="campanas.php" id="beer" data-icon="custom"  rel="external">Campañas</a></li>
			<li><a href="creditos.php" id="coffee" data-icon="custom"  rel="external">Créditos(<?php echo $row_creditos_disponibles['sum(creditos)']; ?>)</a></li>
	</ul>
</div><!-- /navbar -->
</div></div>

<div data-role="content">
  <div class="ui-body-c">
    <h3>Cuadro de Mando</h3>
    
    <div class="ui-grid-a" align="center">
      <div class="ui-block-a">
        <div id="chartContainer" style="width: 100%; height: 350px;"></div><?php if($totalRows_clientes==0) {echo "no tiene clientes afiliados";} else {?>Clientes Referidos: <?php  $var1=($totalRows_referidos/$totalRows_clientes)*100;; echo number_format($var1,2,",","."); ?>%   Clientes Directos: <?php $var2=(($totalRows_clientes-$totalRows_referidos)/$totalRows_clientes)*100; echo number_format($var2,2,",","."); ?>%	<?php } ?>
      </div>
      <div class="ui-block-b">
        <div id="chartContainerb1" style="width: 100%; height: 180px;"></div>
        <div id="chartContainerb2" style="width: 100%; height: 180px;"></div>
      </div>
      
    </div>
  </div>
   <div class="ui-body-a ui-body" >
   <div class="ui-body-a ui-body" data-role="collapsible">
	  <h3>Usuarios VIP del Mes</h3>
		<div data-role="controlgroup"  data-type="horizontal" align="center">
  <?php do { ?>
            
           <a href="#" data-role="button" data-theme="c"><img src="http://curriculum.eku.edu/sites/curriculum.eku.edu/files/people_images/Male_User_Icon_clip_art_hight.png" width="60" height="57"><br><?php echo $row_vips['nombres']; ?><br> <?php echo $row_vips['cr']; ?> Referidos (<?php echo $row_vips['ig']; ?> Bs Generados)</a> <?php } while ($row_vips = mysql_fetch_assoc($vips)); ?>
</div></div>
  </div><!-- /container --> 
    
 <div class="ui-body-c ui-body" >   
  <div data-role="collapsible" data-theme="b" data-content-theme="b">
   <h3>Campañas Realizadas</h3>
   <p><table border="0" align="center" cellpadding="1" cellspacing="1" class="ui-responsive table-stroke" id="my-table" data-role="table"  data-mode="columntoggle">
	 <thead> <tr>
        <th class="ui-bar-b">Fecha de Campaña</td>
        <th class="ui-bar-b">Mensaje Enviado</td>
        <th class="ui-bar-b">Destinatario</td>
         </tr>
      </thead>
      <?php do { ?>
        <tr>
          <td valign="middle" class="ui-body-c"> <?php echo $row_campanas['fecha']; ?></td>
          <td class="ui-body-c"><?php if($row_campanas['mensaje']=="") {$sa="Mensajes de Notificación/Compras/Referidos";}{$sa=$row_campanas['mensaje'];}echo $sa; ?></td>
          <td class="ui-body-c"><?php echo $row_campanas['destinatarios']; ?></td>
         </tr>
        <?php } while ($row_campanas = mysql_fetch_assoc($campanas)); ?>
  </table></p>
   <a href="campanas.php"> Haga click aqui para iniciar una campaña</a> </div>
</div>
<!-- /container --> 
    	

	</div><!-- /container --> 
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
mysql_free_result($clientes);

mysql_free_result($referidos);

mysql_free_result($ventasdiretas);

mysql_free_result($ventas_referidas);

mysql_free_result($ventas_dia);

mysql_free_result($vips);
?>