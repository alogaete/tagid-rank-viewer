<?

header('Content-type: application/x-javascript');

$db="tagid_cla";
$user="root";
$pass="lix16093101ix";
$host="localhost";

$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);

$rawdata = array(); //creamos un array
$i=0;
$query = "SELECT * FROM teams ORDER BY name ASC";
$resp = mysql_query($query, $dbh) or mysql_error($dbh);
 while($row = mysql_fetch_array($resp))
    {
        $rawdata['data'][$i]['name'] = $row['name'];
		$rawdata['data'][$i]['bibs'] = $row['bibs'];
		$rawdata['data'][$i]['bib'] = $row['bib'];
        $i++;
    }
 //echo "(".json_encode($rawdata).");"; exit();
  echo json_encode($rawdata); exit(); //d