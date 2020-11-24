<?php
$db="tagid_mtn";
$user="root";
$pass="linode..-+-+33";
$host="localhost";

$count = 3000;

$query = "SELECT COUNT(*) as c FROM athletes WHERE CONVERT(SUBSTRING_INDEX(tags,'-',-1),UNSIGNED INTEGER) IN (SELECT tag FROM times) ";
		
$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);

mysql_query("SET NAMES utf8",$dbh) or die(mysql_error());
$resp = mysql_query($query, $dbh) or mysql_error($dbh);
$a=0;
while($athete=mysql_fetch_array($resp)){
    $a=$athete['c'];
}

$query = "SELECT bib,name,school,bracket FROM athletes WHERE CONVERT(SUBSTRING_INDEX(tags,'-',-1),UNSIGNED INTEGER) IN (SELECT tag FROM times) ";
		
$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);

mysql_query("SET NAMES utf8",$dbh) or die(mysql_error());
$resp = mysql_query($query, $dbh) or mysql_error($dbh);

?>
<html>
<head>
<title>TAGID</title>

<style type="text/css">
body {
    background-color:#fff;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center top; 
	 -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	font-family: Trebuchet MS;
	color:#000;
	font-size:22px;
}
td {
	font-size:65px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
        $("#div3").hide();
        $("#div3").fadeIn(2000);
		console.log("a vale <?=$a?>");
});
</script>
</head>
<body>
<table width="900" style="position: relative; top: 0px; left:auto; margin: auto;">
<tr>
	<td colspan="10" align="center" style="font-size:30px; height: 35px;"><img src="img/powered.png" align="left" style="height: 35px;">
    RIFA Copa Monte Tabor y Nazaret 2018 by Trek<BR><BR></td>
</tr>
</table>


<table  id="div3" width="900" style="position: relative; top: 0px; left:auto; margin: auto;">
<tr>
    <td colspan="10" align="center" ></td>
</tr>
<BR><BR><BR><BR>
<?php
$div  = '<tr><td colspan=10><hr></td><tr><td style="color:ff0000;">Lugar</td><td style="color:ff0000;">N&uacute;m</td><td style="color:ff0000;">Nombre</td><td style="color:ff0000;">Categor&iacute;a</td>'.
'<td style="color:ff0000;" >Tiempo</td></tr>';
  $min=0;
  $max=$a-1;
  $random = rand($min,$max);
  //echo "total:". $max ." index:" . $random;

$i=0;
while($athete=mysql_fetch_array($resp)){
    if($i++<$random) continue;
    echo "<tr><td>".$athete['bib']."</td><td>".strtoupper($athete['name'])."</td><td style='font-size:48px; '>".$athete['bracket']."</td></tr>";
    break;
}
?>
</table>
<br/><br/>
<table width="900" style="position: relative; top: 0px; left:auto; margin: auto;">
<tr>
	<td colspan="10" align="center" style="font-size:30px; height: 35px;"><FORM>
<INPUT TYPE="button" onClick="history.go(0)" VALUE="Refresh">
</FORM></td>
</tr>
</table>

</body>
</html>
