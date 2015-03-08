<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>prueba de Voz</title>
</head>

<body>
<form id="form1" name="form1" method="get" action="https://rest.nexmo.com/tts/xml?">
  <p>
    <label>
      <textarea name="text" id="text" cols="45" rows="5"></textarea>
    </label>
  </p>
  <p>
    <label for="to"></label>
    <input type="text" name="to" id="to" />
    <input name="api_secret" type="hidden" id="api_secret" value="073043ce" />
    <input name="api_key" type="hidden" id="api_key" value="5dda6743" />
    <input name="lg" type="hidden" id="lg" value="es-mx" />
    <input type="hidden" name="hiddenField4" id="hiddenField4" />
    <input type="submit" name="enviar" id="enviar" value="Enviar" />
  </p>
</form>
</body>
</html>