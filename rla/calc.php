 <META http-equiv="refresh" content="5;URL=http://45.56.121.235/rla/calc.php">
 <?php
$db="tagid_rla"; 
$user="root";
$pass="linode..-+-+33";
$host="localhost";

$start='START';
$finish='FINISH';
$control1='C1';
$control2='C2';

$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);


if($_GET["delete"] == '1'){
    echo "<b>##########################################DELETE OLD TIMES CALC##########################################</b><br>";

    $query =  " UPDATE athletes SET "
             ."   inicio=NULL,inicio_now=NULL,c1 =NULL, c2=NULL, c1_tod =NULL, c2_tod=NULL, fin=NULL, dif_c1= NULL, dif_c2 = NULL, dif_total = NULL, "
             ."   total=NULL, lugar_general = 0 WHERE 1";
    $r = mysql_query($query, $dbh) or mysql_error($dbh); 
}

$query = "SELECT * FROM athletes WHERE (tag1 > 0 AND tag1 IN (SELECT tag FROM times)) OR (tag2 > 0 AND tag2 IN (SELECT tag FROM times)) OR tag1 = '82' ORDER BY bib ASC";
$resp = mysql_query($query, $dbh) or mysql_error($dbh);

echo "<b>##########################################CALC TIMES START##########################################</b><br>";
while($athete=mysql_fetch_array($resp)){

    $athete_id = $athete['id'];
    $athete_name = strtoupper($athete['name']);
    $athete_bib  = $athete['bib'];
    $athete_tag1 = $athete['tag1'];
    $athete_tag2 = $athete['tag2'];

	echo "<br><b> $athete_name - $athete_bib ($athete_tag1, $athete_tag2) - $athete_name </b><br>";

                  //get_rider_start($name, $dbh, $athete_tag1, $athete_tag2, $point_name, $addtime, $subtracttime)
    $time_start = get_rider_start("TOD START", $dbh, $athete_tag1, $athete_tag2, $start, "00:00:00", "00:00:00");
	             //get_rider_control($name, $dbh, $athete_tag1, $athete_tag2, $point_name, $addtime, $subtracttime, $mintime){
    $time_c1_tod = get_rider_control("TOD C1", $dbh, $athete_tag1, $athete_tag2, $control1, "00:00:00", "00:00:00", $time_start);
             //get_rider_time($name, $time_start, $time_finish)
	$time_c1 = get_rider_time("C1", $time_start, $time_c1_tod);
    $time_c2_tod = get_rider_control("TOD C2", $dbh, $athete_tag1, $athete_tag2, $control2, "00:00:00", "00:00:00", $time_start);
    $time_c2 = get_rider_time("C2", $time_start, $time_c2_tod);
    $time_finish = get_rider_finish("TOD FINISH", $dbh, $athete_tag1, $athete_tag2, $finish, "00:00:00", "00:00:00",$time_start);
	$total = get_rider_time("FINISH (TOTAL)", $time_start, $time_finish);

	if($athete_bib == "7") $total = "00:03:46.890";
    #RESUMEN
    $query =  " UPDATE athletes SET "
             ."   inicio='$time_start',inicio_now='2018-10-04 $time_start', c1 ='$time_c1', c2='$time_c2', c1_tod ='$time_c1_tod', c2_tod='$time_c2_tod', fin='$time_finish', "
             ."   total='$total' "
             ." WHERE id = '$athete_id'";
    $r = mysql_query($query, $dbh) or mysql_error($dbh); 
}
echo "<b>---------------CALC TIMES END-----------</b><br>";
echo "<b>##########################################RANK START##########################################</b><br>";

$query = "SELECT * FROM athletes WHERE total > '00:00:00.000' ORDER BY total ASC";
$resp = mysql_query($query, $dbh) or mysql_error($dbh);

$rank=0;
while($athete=mysql_fetch_array($resp)){
    $rank++;
	echo sprintf("LUGAR GENERAL: <b>%03d</b> BIB:  %03d  NAME: %s <br>", $rank, $athete['bib'], $athete['name']);
	$query = "UPDATE athletes SET lugar_general=$rank WHERE id = '".$athete['id']."'";
	$r = mysql_query($query, $dbh) or mysql_error($dbh);
}
echo "<b>-----------RANK END-----------</b><br>";
echo "<b>###########################################GET FIRST RIDER DATA ##############################</b><br>";
$query = "SELECT * FROM athletes WHERE lugar_general = 1 ORDER BY bib ASC";
$resp = mysql_query($query, $dbh) or mysql_error($dbh);

$time_c1_first = "00:00:00.000";
$time_c2_first = "00:00:00.000";
$time_total_first = "00:00:00.000";

if($athete=mysql_fetch_array($resp)){

    $athete_id = $athete['id'];
    $athete_name = strtoupper($athete['name']);
    $athete_rut  = $athete['bib'];
    $athete_tag1 = $athete['tag1'];
    $athete_tag2 = $athete['tag2'];

	echo "<b>$athete_name - $athete_bib ($athete_tag1, $athete_tag2) - $athete_name  </b><br>";
    $time_c1_first = $athete['c1'];
    $time_c2_first = $athete['c2'];
    $time_total_first = $athete['total'];
}
echo "<b>C1 $time_c1_first -  C2 $time_c2_first - TOTAL $time_total_first </b><br>";
echo "<b>-----------GET FIRST RIDER END-------------------</b><br>";
echo "<b>##########################################CALC DIF START#####################################</b><br>";


$query = "SELECT * FROM athletes WHERE (tag1 > 0 AND tag1 IN (SELECT tag FROM times)) OR (tag2 > 0 AND tag2 IN (SELECT tag FROM times)) or tag1 = '82' ORDER BY bib ASC";
$resp = mysql_query($query, $dbh) or mysql_error($dbh);

while($athete=mysql_fetch_array($resp)){

    $athete_id = $athete['id'];
    $athete_name = strtoupper($athete['name']);
    $athete_rut  = $athete['bib'];
    $athete_tag1 = $athete['tag1'];
    $athete_tag2 = $athete['tag2'];


	echo "<br><br><br><b> $athete_name - $athete_bib ($athete_tag1, $athete_tag2) - $athete_name  </b><br>";

	#ENLACE Y ESPECIAL 1
    $time_start = $athete['inicio'];
    $time_c1 = $athete['c1'];
    $time_dif_c1 = get_rider_dif("DIF C1", $time_c1_first, $time_c1);
    $time_c2 = $athete['c2'];
    $time_dif_c2 = get_rider_dif("DIF C2", $time_c2_first, $time_c2);
    $time_total = $athete['total'];
    $time_dif_total = get_rider_dif("DIF TOTAL", $time_total_first, $time_total);

    #RESUMEN
    $query =  " UPDATE athletes SET "
             ."   dif_c1 ='$time_dif_c1', dif_c2='$time_dif_c2', dif_total='$time_dif_total' "
             ." WHERE id = '$athete_id'";
    $r = mysql_query($query, $dbh) or mysql_error($dbh); 
    echo "<b>TIEMPO FINAL: $total</b><br>";
}
echo "<b>-----------------CALC DIF END-----------------</b><br>";


function get_rider_start($name, $dbh, $athete_tag1, $athete_tag2, $point_name, $addtime, $subtracttime){
    $rf_time = get_rider_timeofday($name, $dbh, $athete_tag1, $athete_tag2, $point_name, $addtime, $subtracttime, "DESC", "00:00:00.000");
    if(!$rf_time) return false;
    return get_next_phototime($name, $dbh, $point_name, $rf_time);
}

function get_rider_control($name, $dbh, $athete_tag1, $athete_tag2, $point_name, $addtime, $subtracttime, $mintime){
    return get_rider_timeofday($name, $dbh, $athete_tag1, $athete_tag2, $point_name, $addtime, $subtracttime, "ASC", $mintime);
}

function get_rider_finish($name, $dbh, $athete_tag1, $athete_tag2, $point_name, $addtime, $subtracttime, $mintime){
    $rf_time = get_rider_timeofday($name, $dbh, $athete_tag1, $athete_tag2, $point_name, $addtime, $subtracttime, "ASC", $mintime);
    if(!$rf_time) return false;
    return get_next_phototime($name, $dbh, $point_name, $rf_time);
}

function get_rider_timeofday($name, $dbh, $athete_tag1, $athete_tag2, $point_name, $addtime, $subtracttime, $ASC_DESC, $mintime){
    $query = "SELECT time FROM times WHERE (tag = '$athete_tag1' OR tag = '$athete_tag2') AND location = '$point_name' ORDER BY time $ASC_DESC";
    $r = mysql_query($query, $dbh) or mysql_error($dbh);
    $datetime=null;
    $time = null;
    while($data=mysql_fetch_array($r)){
        $datetime = $data['time'];
        if(!$datetime){
            echo "TIEMPO $name: No Data <br>";
            return false;
        }
        list($date,$time) = explode( ' ', $datetime );
        if($time > $mintime){
            break;
        }
    }
    if($addtime != false && $addtime != "00:00:00.000"){
        $time = add_times($addtime,$time);
    }
    if($subtracttime != false && $subtracttime != "00:00:00.000"){
        $time = subtract_times($subtracttime,$time);
    }
    echo "TIEMPO $name: $time <br>";
    return $time;
}

function get_rider_time($name, $time_start, $time_finish){
    $delta_time = subtract_times($time_start,$time_finish);
    if(!$delta_time){
        echo "TIEMPO $name: No Data <br><br>";
        return false;
    }
	echo "TIEMPO $name: $delta_time <br><br>";
    return $delta_time;
}

function get_rider_dif($name, $time_first, $time_rider){
    $delta_time = "";
    if ( $time_rider ==  $time_first){
        $sign = " ";
        $delta_time = subtract_times($time_first,$time_rider);
    }else if ( $time_rider >  $time_first){
        $sign = "+";
        $delta_time = subtract_times($time_first,$time_rider);
    }else{
        $sign = "-";
        $delta_time = subtract_times($time_rider,$time_first);
    }
    if(!$delta_time){
        echo "DIF $name: No Data <br><br>";
        return false;
    }
    
    $delta_time = substr($delta_time, 4, -1);
    $delta_time = $sign . $delta_time;
    
	echo "DIF $name: $delta_time <br><br>";
    return $delta_time;
}

function get_previous_phototime($name, $dbh, $point_name, $next_time){
    //$next_time = date("Y-m-d ").$next_time;
    $next_time = "2018-10-04 ".$next_time;
	//echo "TIEMPO next_time $name: $next_time <br>";
    $query = "SELECT time FROM times WHERE tag = 'GUNTIME' AND location = '$point_name' AND time < '$next_time' ORDER BY time DESC LIMIT 1";
    //echo "query $query<br>";
    $r = mysql_query($query, $dbh) or mysql_error($dbh);
    $datetime=null;
    $time = null;
    if($data=mysql_fetch_array($r)){
        $datetime = $data['time'];
        if(!$datetime){
            echo "TIEMPO PHOTO $name: No Data <br><br>";
            return false;
        }
        list($date,$time) = explode( ' ', $datetime );
    }
    echo "TIEMPO PHOTO $name: $time <br><br>";
    return $time;
}


function get_next_phototime($name, $dbh, $point_name, $prev_time){
    //$prev_time = date("Y-m-d ").$prev_time;
    $prev_time = "2018-10-04 ".$prev_time;
    //echo "TIEMPO prev_time $name: $prev_time <br>";
    $query = "SELECT time FROM times WHERE tag = 'GUNTIME' AND location = '$point_name' AND time > '$prev_time' ORDER BY time ASC LIMIT 1";
    //echo "query $query<br>";
    $r = mysql_query($query, $dbh) or mysql_error($dbh);
    $datetime=null;
    $time = null;
    if($data=mysql_fetch_array($r)){
        $datetime = $data['time'];
        if(!$datetime){
            echo "TIEMPO PHOTO $name: No Data <br><br>";
            return false;
        }
        list($date,$time) = explode( ' ', $datetime );
    }
    echo "TIEMPO PHOTO $name: $time <br><br>";
    return $time;
}

// $hora2 - $hora1
function subtract_times($hora1,$hora2){
    if(!$hora1 or !$hora2) return false;
    list( $h1, $m1, $s1 ) = explode( ':', $hora1 );
    list( $h2, $m2, $s2 ) = explode( ':', $hora2 );
    list( $se1,$sf1 ) = explode( '.', $s1 );
    list( $se2,$sf2 ) = explode( '.', $s2 );

    //resto los milisegundos
    $sft=$sf2-$sf1;
    if($sft<0){
        $sft=1000+$sft;
        $se2=$se2-1;
    }
    //resto los segundos
    $set=$se2-$se1;
    if($set<0){
        $set=60+$set;
        $m2=$m2-1;
    }
    //resto los minutos 
    $mt=$m2-$m1;
    if($mt<0){
        $mt=60+$mt;
        $h2=$h2-1;
    }
    //resto las horas
    $ht=$h2-$h1;
    return sprintf("%02d:%02d:%02d.%03d", $ht, $mt, $set, $sft);
}

// $hora2 + $hora1
function add_times($hora1,$hora2){
    if(!$hora1 or !$hora2) return false;
    list( $h1, $m1, $s1 ) = explode( ':', $hora1 );
    list( $h2, $m2, $s2 ) = explode( ':', $hora2 );
    list( $se1,$sf1 ) = explode( '.', $s1 );
    list( $se2,$sf2 ) = explode( '.', $s2 );

    //sumo los milisegundos
    $sft=$sf2+$sf1;
    if($sft>=1000){
        $sft=$sft-1000;
        $se2=$se2+1;
    }
    //sumo los segundos
    $set=$se2+$se1;
    if($set>=60){
        $set=$set-60;
        $m2=$m2+1;
    }
    //sumo los minutos 
    $mt=$m2+$m1;
    if($mt>=60){
        $mt=$mt-60;
        $h2=$h2+1;
    }
    $ht=$h2+$h1;
    return sprintf("%02d:%02d:%02d.%03d", $ht, $mt, $set, $sft);
}

?>
