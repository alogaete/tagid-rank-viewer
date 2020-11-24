<?php
$db="tagid_vcaquali";
$user="root";
$pass="linode..-+-+33";
$host="localhost";

$query = "SELECT * FROM athletes WHERE lugar_general > 0 ORDER BY lugar_general ASC";
$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);
$resp = mysql_query($query, $dbh) or mysql_error($dbh);

?>
<html>
<head>
<title>Valpara&iacute;so Cerro Abajo</title>
<style type="text/css">
@font-face {
    font-family: Cut the crap;
    src: url(Cutthecrap.ttf);
}
@font-face {
    font-family: letrachica;
    src: url(book.ttf);
}
body {
    background-image: url(fondo.jpg);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center top; 
	 -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	font-family: Trebuchet MS;
	color:#fff;
	font-size:22px;
}
td {
	font-size:18px;
	font-family: letrachica;
}
table{
    border-radius:5px;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
}
</style>
</head>
<body>
<center><img src="logo.png" style="margin-top:-15px;"></center>
<table width="710" style="position: relative; top: -10px; left:auto; margin: auto;background-color: rgba(0,0,0,0.7);">
<tr>
	<td colspan="10" align="center" style="font-size:36px;font-family:'Cut the crap'">Qualify Rank</td>
</tr>
<tr>
    <td style="color:FFDE0D;font-family:'Cut the crap'">Rank</td>
    <td style="color:FFDE0D;font-family:'Cut the crap'">Bib</td>
    <td style="color:FFDE0D;font-family:'Cut the crap'">Name</td>
    <td style="color:FFDE0D;font-family:'Cut the crap'">Country</td>
    <td style="color:FFDE0D;font-family:'Cut the crap'">Time</td>
    <td style="color:FFDE0D;font-family:'Cut the crap'">Diff</td></tr>
<?
while($athete=mysql_fetch_array($resp))
{
        echo "<tr><td>".$athete['lugar_general']."</td>";
        echo "<td>".$athete['bib']."</td>";
        echo "<td>".$athete['name']."</td>";
        echo "<td>".$athete['country']."</td>";
        echo "<td>".$athete['total']."</td>";
        echo "<td>".$athete['dif_total']."</td></tr>";
}

?>
</table>
<br/><br/><br/>
<center><img src="powered.png"></center>
<br/>
</body>
</html>
