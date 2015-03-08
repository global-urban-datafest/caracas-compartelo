
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

<body >
<div class="ui-body-a" data-role="dialog" id="registerPage">
	
		<div data-role="header" data-theme="d">
			<h1>Prueba de envío</h1>

		</div>

  <div data-role="content" data-theme="c">
			

                        <form action="test_sms.php" method="get"  data-ajax="false" class="ui-body ui-body-b ui-corner-all" id="otra" name="otra">
<fieldset class="ui-grid-a" align="center">
<h4>Ingrese un número de celular para realizar la prueba</h4>
			 
<input type="text"  name="test"  value="" placeholder="ingrese numero..."  /> 	         
<input type="hidden"  name="nombre"  value="<?php echo $_GET['nombre']; ?>"  />            	
<input type="hidden"  name="mensaje"  value="<?php echo $_GET['mensaje']; ?>"  />
<input type="hidden"  name="destino"  value="<?php echo $numeros; ?>"  />
<input type="hidden"  name="usuarios"  value="<?php echo $_GET['usuarios']; ?>"  />
<input type="hidden"  name="origen"  value="<?php echo $_GET['origen']; ?>"  />
<input type="hidden"  name="usuarios"  value="<?php echo $_GET['numero']; ?>"  />
				  
		 
			 
</fieldset><button type="submit" data-theme="b" name="submit" value="submit-value">PROBAR</button>

	
</form>	


                      
	 </div>
</div>

</body>
</html>
