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


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>tured.com</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="js/jquery.mobile-1.2.1.css" />
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.mobile-1.2.1.js"></script>
     <script src="jquery.validate.js"></script>
	<script src="main.js"></script>
	<script type="text/javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
    </script>
</head> 

<body <?php if ($_GET['test']==1) { ?>onload="alert('Mensaje de Prueba enviado al numero seleccionado')"><?php }; 


if($_GET['destino']<>"todos") {$numeros="";
$cantidad=count($_GET['destino']);
for ($i=0;$i<count($_GET['destino']);$i++) {
    $numeros=$_GET['destino'][$i].",".$numeros;

    } 
$larog=strlen($numeros);
$numeros=substr($numeros,0,$larog-1);$_GET['usuarios']=$cantidad;} else {$numeros="todos";}

 ?>
<div class="ui-body-b" data-role="dialog" id="registerPage">
	
		<div data-role="header" data-theme="d">
			<h1>Aviso </h1>

		</div>

  <div data-role="content" data-theme="c">
		<?php if($row_creditos_disponibles['sum(creditos)']<$_GET['usuarios']) {echo "No Dispone de Créditos suficientes para realizar esta campaña de SMS.<br><a href=\"campanas.php\" data-role=\"button\"  data-theme=\"a\" data-rel=\"back\">Volver</a> ";} else {?>	<h4>Confirme que desea enviar el siguiente mensaje:</h4>
            
		<p><h1><?php if($_GET['nombre']=="si") {echo "(Nombre)";}?> <?php echo $_GET['mensaje']; ?></h1></p>
        <p>Este mensaje se enviar&aacute; a  <strong><?php echo $_GET['usuarios']; ?></strong> Usuarios  v&iacute;a mensaje de texto.</p>  
			</p>
            <br />

<a href="#" data-role="button"  data-theme="a" onclick="MM_openBrWindow('test_sms0.php?nombre=<?php echo $_GET['nombre']; ?>&mensaje=<?php echo $_GET['mensaje']; ?>&destino<?php echo $_GET['destino']; ?>&=usuarios=<?php echo $_GET['usuarios']; ?>','Prueba','width=500,height=300')">Probar Como Sus clientes verán el mensaje</a> 

	

            <br />
			
            
                        <form action="envia_mensaje.php" method="get"  data-ajax="false" class="ui-body ui-body-b ui-corner-all" id="otra" name="otra">
<fieldset class="ui-grid-a" align="center">
			 
	         
<input type="hidden"  name="nombre"  value="<?php echo $_GET['nombre']; ?>"  />            	
<input type="hidden"  name="mensaje"  value="<?php echo $_GET['mensaje']; ?>"  />
<input type="hidden"  name="destino"  value="<?php echo $numeros; ?>"  />
<input type="hidden"  name="usuarios"  value="<?php echo $_GET['usuarios']; ?>"  />
<input type="hidden"  name="origen"  value="<?php echo $_GET['origen']; ?>"  />
<input type="hidden"  name="usuarios"  value="<?php echo $_GET['numero']; ?>"  />
				  
		 
			 
</fieldset><button type="submit" data-theme="b" name="submit" value="submit-value">SI, confirmado, Enviar mensaje Masivo</button>
<a href="campanas.php" data-role="button"  data-theme="a" data-rel="back">No, Volver</a> 
	
</form>	


                      
	 </div> <?php } ?>
</div>

</body>
</html>
