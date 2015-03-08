<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aporte Cristalab</title>

<!-- Agrego ficheros -->
<link type="text/css" rel="stylesheet" href="shadowbox.css"/>
<script type="text/javascript" src="jquery-1.6.4.min.js"></script><!-- Omitir si Jquery ya esta incluido -->
<script type="text/javascript" src="shadowbox.js"></script>
<!-- Agrego ficheros -->
<script type="text/javascript">/* Inicializo y agrego las opciones que quiera, las pueden encontrar aqui http://www.shadowbox-js.com/options.html */
$().ready(function(){
	
	
	Shadowbox.init( {
	handleOversize: "drag",
    modal: true
	});
	
 });
</script>


</head>

<body>

<!-- Para ejecutar un contenido al cargar la pagina   -->

<script>
 window.setTimeout(function(){
        Shadowbox.open({
            content: 'tured.png', //el elemento que se va a cargar, tambien puede ser directamente html: ej: <h2>Hola Mundo</h2>
            player: 'img',   //el tipo de elemento** 
			width: "800",//solo es requerido para videos
			height: "1600",//solo es requerido para videos
			title: "Presione ESC para salir",
          });
      }, 200);
 
/* 

** =  		img     Sirve para :   ['png', 'jpg', 'jpeg', 'gif', 'bmp']
            swf     Sirve para :   ['swf'], 
            flv     Sirve para :   ['flv'], 
            qt      Sirve para :   ['dv', 'mov', 'moov', 'movie', 'mp4'], 
            wmp     Sirve para :   ['asf', 'wm', 'wmv'], 
            qtwmp   Sirve para :   ['avi', 'mpg', 'mpeg'], 
            iframe  Sirve para :   ['asp', 'aspx', 'cgi', 'cfm', 'htm', 'html', 'pl', 'php', 
                        'php3', 'php4', 'php5', 'phtml', 'rb', 'rhtml', 'shtml', 
                        'txt', 'vbs', 'java'] 
						
*/
</script>
<!-- Para ejecutar un contenido al cargar la pagina   -->


</body>
</html>