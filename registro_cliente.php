<?php require_once('Connections/local.php'); ?>
<?php
mysql_select_db($database_local, $local);
$query_usuarios = "SELECT * FROM usuarios";
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
    		<li><a href="compras.php" id="chat" data-icon="custom" <?php if($_GET['bono']=="") {  echo "class=\"ui-btn-active ui-state-persist\"";  } ?> 	 rel="external">Registrar Compra</a></li>
			<li><a href="consulta.php" id="email" data-icon="custom"  rel="external" <?php if($_GET['bono']>0) { echo "class=\"ui-btn-active ui-state-persist\""; }; ?>>Consultas</a></li>
			<li><a href="reporte.php" id="skull" data-icon="custom"  rel="external">Reportes</a></li>
			<li><a href="campanas.php" id="beer" data-icon="custom"  rel="external">Campañas</a></li>
			<li><a href="creditos.php" id="coffee" data-icon="custom" rel="external">Créditos</a></li>
	</ul>
</div>

</div></div>

<div data-role="content">	
<h3>Datos del Cliente</h3>
<div class="ui-body ui-body-b">
<div id="errorBox"><ul></ul></div>
<form action="registro.php" method="get"  data-ajax="false" class="ui-body ui-body-a ui-corner-all" id="registerForm">
<?php if($_GET['error']==1) {echo "<strong>El cliente con la c&eacute;dula ".$_GET['requsername']." ya est&aacute; registrado en el sistema.</strong><br><br>"; }?><fieldset class="ui-grid-a" align="center">
			 
	        <div class="ui-block-a">Numero de Cédula<input type="text" name="texto" id="texto" class="required digits" value=""  /><br>
			Numero de Celular<input type="text" name="numero" id="numero" value="" class="required digits"  /><br>
				 <button type="submit" data-theme="b" name="submit" value="submit-value">Registrar Cliente</button></div>
		 
			 
</fieldset>
	<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_GET['id_usuario']; ?>"  />	
	<input type="hidden" name="referido_por" id="referido_por" value="<?php echo $_GET['referido_por']; ?>"  />
    <input type="hidden" name="viene" id="viene" value="<?php echo $_GET['viene']; ?>"  />	
    
	<input type="hidden" name="bono" id="bono" value="<?php echo $_GET['bono']; ?>"  />	
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
mysql_free_result($usuarios);
?>