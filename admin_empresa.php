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
$query_usuarios = "SELECT * from empresas";
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
    
    

</head> 

<style>	
		.nav-glyphish-example .ui-btn .ui-btn-inner { padding-top: 40px !important; }
		.nav-glyphish-example .ui-btn .ui-icon { width: 30px!important; height: 30px!important; margin-left: -15px !important; box-shadow: none!important; -moz-box-shadow: none!important; -webkit-box-shadow: none!important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
		#chat .ui-icon { background:  url(glyphish-icons/119-piggy-bank.png) 50% 50% no-repeat; }
		#email .ui-icon { background:  url(glyphish-icons/190-bank.png) 50% 50% no-repeat;}
		#login .ui-icon { background:  url(glyphish-icons/30-key.png) 50% 50% no-repeat; }
		#beer .ui-icon { background:  url(glyphish-icons/02-redo.png) 50% 50% no-repeat; }
		#coffee .ui-icon { background:  url(glyphish-icons/16-line-chart.png) 50% 50% no-repeat;}
		#skull .ui-icon { background:  url(glyphish-icons/112-group.png) 50% 50% no-repeat; }
	</style>
<body> 
<!-- Start of first page: #one -->
<div data-role="page">

	<div data-role="header" data-theme="e">
	<a href="logout.php" data-icon="delete"  rel="external">Salir</a>
	<h1>TuRed.com - Panel de Administraci&oacute;n</h1>
	
<div class="ui-body-d ui-body">
<div data-role="navbar" class="nav-glyphish-example" data-grid="c" >
	<ul>
			<li><a href="admin_empresa.php" id="email" data-icon="custom"  rel="external"  class="ui-btn-active ui-state-persist" >Empresas</a></li>
			<li><a href="admin_cuentas.php" id="skull" data-icon="custom"  rel="external">Cuentas</a></li>
			<li><a href="admin_creditos" id="beer" data-icon="custom"  rel="external">Agregar Creditos</a></li>
			<li><a href="admin_reportes.php" id="coffee" data-icon="custom" rel="external">Reportes</a></li>
	</ul>
</div>
 <div class="ui-body-d ui-body" >
</div><!-- /navbar -->



<div data-role="content">	

 

<ul data-role="listview" data-theme="c" data-dividertheme="d" data-filter="true" data-inset="true" data-filter-placeholder="Ingrese datos de la empresa">
<li data-role="list-divider">Empresas Registradas</li>
						<?php do { ?><li><a href="index.html"><img src="images/noimage.jpg" />
				
					<h3><?php echo $row_usuarios['empresa_nombre']; ?> (<?php echo $row_usuarios['empresa_sector']; ?>)</h3>
					<p><strong>RIF:<?php echo $row_usuarios['empresa_rif']; ?> - Estado:<?php echo $row_usuarios['empresa_estado']; ?></strong></p>
					<p><?php echo $row_usuarios['empresa_direccion']; ?></p>
                    <p>Persona de Contacto:<?php echo $row_usuarios['empresa_contacto']; ?> (<?php echo $row_usuarios['empresa_tel1']; ?>/<?php echo $row_usuarios['empresa_tel2']; ?>)</p>
					
				
			</a></li>
						<?php } while ($row_usuarios = mysql_fetch_assoc($usuarios)); ?>
						
</ul>
<a href="add_empresa.php?" data-role="button"  data-theme="b" rel="external">Registrar Empresa Nueva</a>
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