<?php
require_once 'config.php';

$count = 3;
if (array_key_exists('count', $_GET)) {
	$count=$_GET['count'];
}

$query = "SELECT * FROM athletes WHERE " .
        " bracket_rank <= $count AND bracket_rank > 0".
        " ORDER BY bracket ASC, bracket_rank ASC";
		
$dbh = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME) or mysql_error($dbh);

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
	<td colspan="10" align="center" style="font-size:30px; height: 35px;"><img src="img/powered.png" align="left" style="height: 35px;"><?=EVENT_NAME?></td>
</tr>
<tr>
    <td colspan="10" align="center" ></td>
</tr>
<?php
$div  = '<tr><td colspan=10><hr></td><tr><td style="color:ff0000;">Lugar</td><td style="color:ff0000;">N&uacute;m</td><td style="color:ff0000;">Nombre</td><td style="color:ff0000;">Categor&iacute;a</td>'.
'<td style="color:ff0000;" >Giros</td><td style="color:ff0000;" >Tiempo</td></tr>';

$last = 'x';
while($athete=mysql_fetch_array($resp)){
    if ($last != $athete['bracket'] ) echo $div;
    $last = $athete['bracket'];
    echo "<tr><td>".$athete['bracket_rank']."</td><td>".$athete['bib']."</td><td>".strtoupper($athete['name'])."</td><td>".$athete['bracket']."</td><td>".$athete['laps_count']."</td><td>".$athete['time']."</td></tr>";
}
?>
</table>
<br/><br/>
</body>
</html>
