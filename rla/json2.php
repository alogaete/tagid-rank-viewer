<?php
$db='tagid_rla';
$user='root';
$pass='linode..-+-+33';
$host='localhost';

//TOPTEN
$query = 'SELECT * FROM athletes WHERE lugar_general > 0 ORDER BY lugar_general ASC LIMIT 10';
$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);
$resp = mysql_query($query, $dbh) or mysql_error($dbh);
$num = mysql_num_rows($resp);
$counter = 0;
echo '{"topten":[';
while($athete=mysql_fetch_array($resp))
{
	echo '{';
        echo '"rank":"'.$athete['lugar_general'].'",';
        echo '"bib":"'.$athete['bib'].'",';
        echo '"name":"'.$athete['name'].'",';
        echo '"country":"'.$athete['country'].'",';
        echo '"c1_diff":"'.$athete['dif_c1'].'",';
        echo '"c2_diff":"'.$athete['dif_c2'].'",';
        echo '"time":"'.$athete['total'].'",';
        echo '"diff":"'.$athete['dif_total'].'"';
	echo '}';
	if (++$counter <> $num)
		echo ',';
}
echo ']';

//STARTED
$query = 'SELECT *  FROM athletes WHERE inicio_now > DATE_SUB(NOW(), INTERVAL 10 SECOND) ORDER BY inicio_now DESC LIMIT 1';
$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);
$resp = mysql_query($query, $dbh) or mysql_error($dbh);
while($athete=mysql_fetch_array($resp))
{
echo ',"started":"'.$athete['bib'].'"';
}

//ONCOURSE
echo ',"oncourse":[';
$query = 'SELECT *  FROM athletes WHERE (inicio is not NULL AND inicio <>"") AND (total is NULL or total = "")  ORDER BY inicio DESC LIMIT 1';
$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);
$resp1 = mysql_query($query, $dbh) or mysql_error($dbh);

$num1 = mysql_num_rows($resp1);
$counter1 = 0;

while($athete=mysql_fetch_array($resp1))
{
        echo '{';
        echo '"rank":"-",';
        echo '"bib":"'.$athete['bib'].'",';
        echo '"name":"'.$athete['name'].'",';
        echo '"country":"'.$athete['country'].'",';
        echo '"c1":"'.$athete['c1'].'",';
        echo '"c1_diff":"'.$athete['dif_c1'].'",';
        echo '"c2":"'.$athete['c2'].'",';
        echo '"c2_diff":"'.$athete['dif_c2'].'",';
        echo '"time":"on course",';
        echo '"diff":"'.$athete['dif_total'].'"';
        echo '}';
	if (++$counter1 <> $num1)
		echo ',';

}

echo ']';




echo '}';
?>
