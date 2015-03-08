<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
	<title>tured.com</title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="js/jquery.mobile-1.2.1.css" />
	<script src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.mobile-1.2.1.js"></script>
   
    s</head> 

<body>
<div class="ui-body-b" data-role="dialog">
	
		<div data-role="header" data-theme="d">
			<h1>Aviso</h1>

		</div>

  <div data-role="content" data-theme="c">
			<h1>Compra Registrada </h1>
            <?php if($_GET['resto']>0) {?><p>Al utilizar el Bono quedaron por Facturar <?php echo number_format($_GET['resto'],2,",","."); ?>  Bs.</p> <?php } ?>
			<?php if($_GET['bono']<>0) {?><p>El descuento Utiizado fue de <?php echo number_format($_GET['bono'],2,",","."); ?> Bs.</p>  <?php } ?>
			<p>En breves momentos el cliente recibir&aacute; un mensaje de texto con la informaci&oacute;n de su compra, incluido un bono para su proxima visita!</p>
			<a href="reporte.php" data-role="button"  data-theme="b" rel="external">Continuar</a>       
	 </div>
</div>

</body>
</html>
