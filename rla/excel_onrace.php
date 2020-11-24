<?php
require_once 'Spreadsheet/Excel/Writer.php';
require_once 'Spreadsheet/Excel/Writer.php';

// Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

// sending HTTP headers
$workbook->send('onrace.xls');

// Creating a worksheet
$worksheet =& $workbook->addWorksheet('My first worksheet');

// The actual data
$worksheet->write(0,0,'ON RACE NOW');

$db='tagid_rla';
$user='root';
$pass='linode..-+-+33';
$host='localhost';

//ONCOURSE
$query = 'SELECT *  FROM athletes WHERE (inicio is not NULL AND inicio <>"") AND (total is NULL or total = "")  ORDER BY inicio DESC LIMIT 1';
$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);
$resp1 = mysql_query($query, $dbh) or mysql_error($dbh);

$num1 = mysql_num_rows($resp1);

while($athete=mysql_fetch_array($resp1))
{
	$worksheet->write(1,0,$athete['bib']);
	$worksheet->write(2,0,$athete['name']);
	$worksheet->write(3,0,$athete['country']);
	$worksheet->write(4,0,'CP1');
	$worksheet->write(5,0,$athete['c1']);
	$worksheet->write(6,0,'CP2');
	$worksheet->write(7,0,$athete['c2']);
	$worksheet->write(8,0,'TTR');
	$worksheet->write(10,0,$athete['total']);
	break;
}

// Let's send the file
$workbook->close();

?>
