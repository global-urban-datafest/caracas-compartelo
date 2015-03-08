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
$query_creditos_disponibles = "SELECT sum(creditos) FROM creditos WHERE empresa_id ='".$_SESSION['MM_UserGroup']."'";
$creditos_disponibles = mysql_query($query_creditos_disponibles, $local) or die(mysql_error());
$row_creditos_disponibles = mysql_fetch_assoc($creditos_disponibles);
$totalRows_creditos_disponibles = mysql_num_rows($creditos_disponibles);
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="add_user2.php?error=1";
  $loginUsername = $_POST['usuario_login'];
  $LoginRS__query = sprintf("SELECT usuario_login FROM usuarios_empresas WHERE usuario_login=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_local, $local);
  $LoginRS=mysql_query($LoginRS__query, $local) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "registerForm")) {
  $insertSQL = sprintf("INSERT INTO usuarios_empresas (empresa_id, usuario_email, usuario_email2, usuario_telf, usuario_login, usuario_pass) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['empresa_id'], "text"),
                       GetSQLValueString($_POST['usuario_email'], "text"),
                       GetSQLValueString($_POST['usuario_email2'], "text"),
                       GetSQLValueString($_POST['usuario_telf'], "text"),
                       GetSQLValueString($_POST['usuario_login'], "text"),
                       GetSQLValueString($_POST['usuario_pass'], "text"));

  mysql_select_db($database_local, $local);
  $Result1 = mysql_query($insertSQL, $local) or die(mysql_error());

  $insertGoTo = "add_user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
<?php if($_GET['bono']=="") { ?>
 <div class="ui-body-d ui-body" >
</div><!-- /navbar --><?php }?>
</div></div>

<div data-role="content">	
<h3>Datos del usuario</h3>
<div class="ui-body ui-body-b">
<div id="errorBox"><ul></ul></div>

<form action="<?php echo $editFormAction; ?>" name="registerForm" method="POST"  data-ajax="false" class="ui-body ui-body-a ui-corner-all" id="registerForm">
<fieldset class="ui-grid-a" align="center">
			 
	        <div class="ui-block-a"><?php if($_GET['error']==1) {echo "<strong>EL USUARIO ".$_GET['requsername']." Ya esta registrado, por favor prueba con otro</strong>.<br><br>";}?>Login 
	          <input type="text"  name="usuario_login" id="usuario_login" value="" class="required"  />
	          Contraseña
	          <input type="text" name="usuario_pass"  id="usuario_pass" value="" class="required"  />
	          Telf
	          <input type="text" name="usuario_telf"   id="usuario_telf" value="" class="required digits"  />
	        </div>
                      <div class="ui-block-b" > <span class="ui-block-a">Email
                          <input type="text" name="usuario_email"  id="usuario_email" value="" class="required email"  />
Email2
<input type="text" name="usuario_email2"  id="usuario_email2" value=""  />
<input type="hidden" name="empresa_id"  id="empresa_id" value="<?php echo $_GET['empresa_id']; ?>"  />
 
 
                      </span><br>
             
				 </div>
		 
			 
</fieldset> <button type="submit" data-theme="c" name="submit" value="submit-value">Registrar Nuevo usuario</button>
<input type="hidden" name="MM_insert" value="registerForm">
</form>		
</div><!-- /content -->

<div data-role="footer" class="footer-docs" data-theme="b" align="center">
		 
		<p>tured.com 2013</p>
  </div>
</div>

<!-- /page -->




</body>
</html>
<?php
mysql_free_result($creditos_disponibles);
?>
