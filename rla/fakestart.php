<?php


$db="tagid_rla"; 
$user="root";
$pass="linode..-+-+33";
$host="localhost";

$tag = $_GET["tag"];
$time1 = "2017-02-19 " . $_GET["time"] . ".000"; 
$time2 = "2017-02-19 " . $_GET["time"] . ".290";
$point = $_GET["point"];


$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);

$query =  " INSERT INTO `times`(`event_name`, `location`, `time`, `tag`) VALUES ( 'FAKE','$point','$time1','$tag')";
echo $query;
echo "<br><br>";
$r = mysql_query($query, $dbh) or mysql_error($dbh); 

$query =  " INSERT INTO `times`(`event_name`, `location`, `time`, `tag`) VALUES ( 'FAKE','$point','$time2','GUNTIME')";
echo $query; 
echo "<br><br>";
$r = mysql_query($query, $dbh) or mysql_error($dbh); 

if($_GET["delete"] && $_GET["delete"] == "1"){
    $query =  " DELETE FROM `times` WHERE event_name = 'FAKE'";
    echo $query; 
    echo "<br><br>";
    $r = mysql_query($query, $dbh) or mysql_error($dbh);
}

?>