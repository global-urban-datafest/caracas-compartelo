<?php


$vowels=array("</font>","<b>","</b>","</td>","<td align=\"left\">","</td>","<tr>","</tr>","<font color=\"#00387b\">","Estado","Municipio");
$texto=str_replace($vowels,"",$texto);


echo $texto;

?>