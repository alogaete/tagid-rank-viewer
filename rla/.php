<?
$db="tagid_ctm";
$user="root";
$pass="lix16093101ix";
$host="localhost";

$especial1finish = 'ESPECIAL1FINISH';
$especial2finish = 'ESPECIAL2FINISH';
$especial3finish = 'ESPECIAL3FINISH';


$text= "Final PRO";



$posiciones = array();
//calculo posiciones
if(!$_GET['selector']){

	$query = "SELECT * FROM athletes WHERE especial1 > '00:00:00.000'  
    AND ( tag1 IN (SELECT tag FROM times WHERE location = '$especial1finish')  OR tag2 IN (SELECT tag FROM times WHERE location = '$especial1finish'))
    AND bracket = 'HOMBRES PRO'
    ORDER BY especial1 ASC";
	$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
	mysql_select_db($db) or mysql_error($dbh);
	$resp = mysql_query($query, $dbh) or mysql_error($dbh);

	$x=0;
	while($athete=mysql_fetch_array($resp))
	{
		$x++;
		$posiciones[$athete['bib']]['e1'] = $x;
	}

	$query = "SELECT * FROM athletes WHERE especial2 > '00:00:00.000'
    AND ( tag1 IN (SELECT tag FROM times WHERE location = '$especial2finish')  OR tag2 IN (SELECT tag FROM times WHERE location = '$especial2finish')) 
    AND bracket = 'HOMBRES PRO'
    ORDER BY especial2 ASC";
	$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
	mysql_select_db($db) or mysql_error($dbh);
	$resp = mysql_query($query, $dbh) or mysql_error($dbh);

	$x=0;
	while($athete=mysql_fetch_array($resp))
	{
		$x++;
		$posiciones[$athete['bib']]['e2'] = $x;
	}

	$query = "SELECT * FROM athletes WHERE especial3 > '00:00:00.000'
    AND ( tag1 IN (SELECT tag FROM times WHERE location = '$especial3finish')  OR tag2 IN (SELECT tag FROM times WHERE location = '$especial3finish')) 
    AND bracket = 'HOMBRES PRO'
    ORDER BY especial3 ASC";
	$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
	mysql_select_db($db) or mysql_error($dbh);
	$resp = mysql_query($query, $dbh) or mysql_error($dbh);

	$x=0;
	while($athete=mysql_fetch_array($resp))
	{
		$x++;
		$posiciones[$athete['bib']]['e3'] = $x;
	}
}

$query = "SELECT * FROM athletes WHERE especial1 > '00:00:00.000' AND especial2 > '00:00:00.000' AND especial3 > '00:00:00.000'
        AND ( tag1 IN (SELECT tag FROM times WHERE location = '$especial3finish')  OR tag2 IN (SELECT tag FROM times WHERE location = '$especial3finish')) 
        AND bracket = 'HOMBRES PRO'
        ORDER BY lugar_categoria ASC";
if ($_GET['selector'] and $_GET['selector'] == '1'){
	$query = "SELECT * FROM athletes WHERE especial1 > '00:00:00.000'
        AND ( tag1 IN (SELECT tag FROM times WHERE location = '$especial1finish')  OR tag2 IN (SELECT tag FROM times WHERE location = '$especial1finish'))
        AND bracket = 'HOMBRES PRO'
        ORDER BY acumulado_especial1 ASC";
	$text= " Acumulado Especial 1 PRO";
}else if ($_GET['selector'] and $_GET['selector'] == '2'){
	$query = "SELECT * FROM athletes WHERE especial1 > '00:00:00.000' AND especial2 > '00:00:00.000'
        AND ( tag1 IN (SELECT tag FROM times WHERE location = '$especial2finish')  OR tag2 IN (SELECT tag FROM times WHERE location = '$especial2finish'))
        AND bracket = 'HOMBRES PRO'
        ORDER BY acumulado_especial2 ASC";
	$text= " Acumulado Especial 2 PRO";
}

$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);

$resp = mysql_query($query, $dbh) or mysql_error($dbh);

?>
<html>
<head>
<title>Ranking Enduro</title>

<style type="text/css">
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
}
table{
    border-radius:10px;
    -moz-border-radius:10px;
    -webkit-border-radius:10px;
}
</style>
</head>
<body>
<center><img src="logo.png" width="400px"></center>
<table width="900" style="position: relative; top: 50px; left:auto; margin: auto;background-color: rgba(0,0,0,0.7);">
<tr>
	<td colspan="10" align="center" style="font-size:42px">Ranking <? echo $text;?></td>
</tr>
<tr>
    <td colspan="10" align="center" ></td>
</tr>

<tr>
    <td style="color:ff0000;">Lugar</td><td style='color:ff0000;'>Lugar Categoria</td><td style="color:ff0000;">N&uacute;m</td><td style="color:ff0000;">Nombre</td><td style="color:ff0000;">Categor&iacute;a</td>
<?if(!$_GET['selector']){?>
<td style="color:ff0000;" align="center">E1</td><td style="color:ff0000;" align="center">E2</td><td style="color:ff0000;" align="center">E3</td><?}?><td style="color:ff0000;" >Total</td></tr>
</tr>
<?
$x=0;
while($athete=mysql_fetch_array($resp))
{
    $lugar_categoria = $athete['lugar_categoria'];
	$x++;
	if ($_GET['selector'] and $_GET['selector'] == '1'){
		echo "<tr><td>$x</td><td>".$athete['bib']."</td><td>".strtoupper($athete['name'])."</td><td>".$athete['bracket']."</td><td>".$athete['especial1']."</td></tr>";
	}else if ($_GET['selector'] and $_GET['selector'] == '2'){
		echo "<tr><td>$x</td><td>".$athete['bib']."</td><td>".strtoupper($athete['name'])."</td><td>".$athete['bracket']."</td><td>".$athete['acumulado_especial2']."</td></tr>";
	}else{
    echo "<tr><td>$lugar_categoria</td><td>$lugar_categoria</td><td>".$athete['bib']."</td><td>".strtoupper($athete['name'])."</td><td>".$athete['bracket']."</td><td style='font-size:10px;font-weight:normal;'>".$athete['especial1']." (".$posiciones[$athete['bib']]['e1'].")</td><td style='font-size:10px;font-weight:normal;'>".$athete['especial2']." (".$posiciones[$athete['bib']]['e2'].")</td><td style='font-size:10px;font-weight:normal;'>".$athete['especial3']." (".$posiciones[$athete['bib']]['e3'].")</td><td>".$athete['total']."</td></tr>";
	}

}

?>
</table>
<br/><br/><br/>
<center><img src="powered.png"></center>
<br/>
</body>
</html>
