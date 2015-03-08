
<!DOCTYPE html>
<html>
<head>
<script>
function loadXMLDoc(epa)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
}
xmlhttp.open("GET",epa,true);
xmlhttp.send();
}
</script>
</head>
<body onLoad="loadXMLDoc('http://touchsms.com.ve/clientes/apicall-touch.php?texto=exceleten&telf=04166180003&pass=developer&login=developer&id_cuenta=0&id_cuenta_hija=0')" > 
</body>
</html>