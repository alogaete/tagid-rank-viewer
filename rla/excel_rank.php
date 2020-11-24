<?php
require_once 'Spreadsheet/Excel/Writer.php';
require_once 'Spreadsheet/Excel/Writer.php';

// Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

// sending HTTP headers
$workbook->send('rank.xls');

// Creating a worksheet
$worksheet =& $workbook->addWorksheet('My first worksheet');

// The actual data
$worksheet->write(0,0,'Ranking');
$worksheet->write(0,1,'Atleta');
$worksheet->write(0,2,'Num.');
$worksheet->write(0,3,'Tiempo');

$db='tagid_rla';
$user='root';
$pass='linode..-+-+33';
$host='localhost';

$query = 'SELECT * FROM athletes WHERE lugar_general > 0 ORDER BY lugar_general ASC LIMIT 50';
$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);
$resp = mysql_query($query, $dbh) or mysql_error($dbh);
$num = mysql_num_rows($resp);
$counter = 0;

while($athete=mysql_fetch_array($resp))
{
	$worksheet->write($counter,0,$athete['lugar_general']);
	$worksheet->write($counter,1,$athete['name']);
	$worksheet->write($counter,2,$athete['bib']);
	$worksheet->write($counter,3,$athete['total']);
	$counter++;
}

// Let's send the file
$workbook->close();

?>
