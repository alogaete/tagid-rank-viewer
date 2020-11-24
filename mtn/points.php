<?php
$db="tagid_mtn";
$user="root";
$pass="linode..-+-+33";
$host="localhost";

$count = 100;
if (array_key_exists('count', $_GET)) {
	$count=$_GET['count'];
}

$query = "SELECT school, SUM(points) as sum_points FROM athletes WHERE 1 " .
        " GROUP BY school ORDER BY sum_points DESC";
		
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
	font-size:18px;
}
</style>
</head>
<body>
<table width="900" style="position: relative; top: 0px; left:auto; margin: auto;">
<tr>
	<td colspan="10" align="center" style="font-size:30px; height: 35px;"><img src="img/powered.png" align="left" style="height: 35px;">Puntos Copa Monte Tabor y Nazaret 2018 by Trek</td>
</tr>
<tr>
    <td colspan="10" align="center" ></td>
</tr>
<?php
$last = 'x';
$i = 0;
echo '<tr><td colspan=10><hr></td><tr><td style="color:ff0000;">Lugar</td><td style="color:ff0000;">Nombre Colegio</td><td style="color:ff0000;">Puntos</td></tr>';
while($athete=mysql_fetch_array($resp)){
	if($athete['sum_points'] == 0) continue;
    echo "<tr><td>".++$i."</td><td>".strtoupper($athete['school'])."</td><td>".$athete['sum_points']."</td></tr>";
    if ($i >= $count) break;
}
?>
</table>
<br/><br/>
</body>
</html>
