<?php require_once 'config.php'; ?>
<META http-equiv="refresh" content="30;URL=<?=URL_BASE?>calc.php">
<?php
echo strtoupper("<b>##### START CALC - EVENT ".EVENT_NAME." #####</b><br>");
//exit("stopped");

$dbh = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME) or mysql_error($dbh);

//###################################################################################################################################################
echo  strtoupper("<b>##### START ATH TIME CALC #####</b><br>");

$goal='META';
$control='CONTROL';

$bracket_windows = array();
$bracket_windows["VERDE"] = array( "start" => "12:02:00.000", "finish" => "22:00:00.000", "max_laps" => "5");
$bracket_windows["AZUL VARONES"] = array( "start" => "12:18:23.000", "finish" => "22:00:00.000", "max_laps" => "5");
$bracket_windows["AZUL MIXTO"] = array( "start" => "12:38:13.000", "finish" => "22:00:00.000", "max_laps" => "5");

$aths = array();
$query = "SELECT * FROM athletes ORDER BY id ASC";
mysql_query("SET NAMES utf8",$dbh) or die(mysql_error());
$resp = mysql_query($query, $dbh) or mysql_error($dbh);
while($ath=mysql_fetch_array($resp)){
    $ath_id = $ath['id'];
    $ath_name = strtoupper($ath['name']);
	$ath_bracket = $ath['bracket'];
	$ath_bib = $ath['bib'];
    $ath_tags = "'".implode("','", explode(';', $ath['tags']))."'";
	$bracket_window = $bracket_windows[$ath_bracket];
	if(!$bracket_window) $bracket_window = array( "start" => "9:00:00.000", "finish" => "22:00:00.000", "max_laps" => "5");
	
    echo "<br><br><br><b>$ath_bib - bracket: $ath_bracket - name: $ath_name - start time: ".$bracket_window["start"]."</b><br>";
    list ($laps, $laps_details, $end_time) = calc_laps($dbh, $ath_bib, $ath_name, $ath_tags, $bracket_window["start"], $bracket_window["finish"], $goal, $control, $bracket_window["max_laps"], $ath_bracket);
	//sort($laps);
	$laps_size = count($laps);
    //$pp_time_best = '';
    //if($laps_size >= 1){
    //    $pp_time_best = $laps[0];
    //}
    //echo "quickest_lap:$pp_time_best<br>";

	$time = subtract_times($bracket_window["start"],$end_time);
    
	if($ath_bib == "8" || $ath_bib == "7" || $ath_bib == "5"){
		$laps_size = 5;
    }
    
	if($ath_bib == "1" || $ath_bib == "8"){
		$laps_size = 6;
    }
	
    echo "<br><br><br><b> window_start:".$bracket_window["start"]." end_time:$end_time time:$time</b><br>";
				
    $query =  " UPDATE athletes SET time='$time', "
				."  laps_details='$laps_details', laps_count=$laps_size "
				."  WHERE id = '$ath_id'";
    $r = mysql_query($query, $dbh) or mysql_error($dbh);
}

echo  strtoupper("<b>##### END ATH TIME CALC #####</b><br>");
//###################################################################################################################################################
echo  strtoupper("<b>#####  START ATH RANK   #####</b><br>");

$query = "UPDATE athletes SET bracket_rank=0";
$resp = mysql_query($query, $dbh) or mysql_error($dbh);

$query = "SELECT * FROM athletes WHERE time > '00:00:00.000' ORDER BY laps_count DESC, time ASC";
$resp = mysql_query($query, $dbh) or mysql_error($dbh);
$x=0;
$br = array();
while($athete=mysql_fetch_array($resp)){
	$x++;
	$bracket = $athete['bracket'];
	if (array_key_exists($bracket, $br)) {
		$br[$bracket]++;
	}else{
		$br[$bracket]=1;
	}
	$bracket_rank=$br[$bracket];
	echo sprintf("LUGAR OVERALL: <b>%03d</b> LUGAR BRACKET: <b>%03d</b> BRACKET: %s BIB-NAME: %s <br>", $x, $bracket_rank, $bracket, $athete['bib'] . " " . $athete['name']);
	
	$q = "UPDATE athletes SET bracket_rank='".$bracket_rank."' WHERE id = '".$athete['id']."'";
	$r = mysql_query($q, $dbh) or mysql_error($dbh);
}
echo  strtoupper("<b>#####  END ATH RANK   #####</b><br>");

echo strtoupper("<b>##### END CALC - EVENT ".EVENT_NAME." #####</b><br>");

mysql_close($dbh);

//###################################################################################################################################################
function get_athlete_first($name, $dbh, $tags, $location, $mintime, $maxtime, $bracket){
    return get_athlete_timeofday($name, $dbh, $tags, $location, "ASC", $mintime, $maxtime, $bracket);
}

function get_athlete_last($name, $dbh, $tags, $location, $mintime, $maxtime, $bracket){
    return get_athlete_timeofday($name, $dbh, $tags, $location, "DESC", $mintime, $maxtime, $bracket);
}
    
function get_athlete_timeofday($name, $dbh, $tags, $location, $ASC_DESC, $mintime, $maxtime, $bracket){
    $max_min_times = "";
    if($mintime){
		$mindatetime =  "2018-11-03 ".$mintime;
        $max_min_times = $max_min_times." AND time >= '$mindatetime' ";
    }
    if($maxtime){
		$maxdatetime =  "2018-11-03 ".$maxtime;
        $max_min_times = $max_min_times." AND time <= '$maxdatetime' ";
    }
    
    $query = "SELECT time FROM times WHERE tag IN ($tags) AND ".
			"location = '$location' AND (event_name = 'FM' OR tag IN ('2092','2119','2194'))".
			" $max_min_times ORDER BY time $ASC_DESC LIMIT 1";
    //exit($query);
    
    $r = mysql_query($query, $dbh) or mysql_error($dbh);
    $datetime=null;
    $time = null;
    if($data=mysql_fetch_array($r)){
        $datetime = $data['time'];
        if(!$datetime){
            echo "TIEMPO $name: No Data <br>";
            return false;
        }
        list($date,$time) = explode( ' ', $datetime );
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

function kmh($hora1,$dist){
    list( $h1, $m1, $s1 ) = explode( ':', $hora1 );
    $h1 = number_format($h1,8);
    $m1 = number_format($m1,8);
    $s1 = number_format($s1,8);
    $h = $h1 + ($m1/60) + ($s1/60/60);
    
    return number_format($dist/$h,1);
}


function calc_laps($dbh, $ath_bib, $ath_name, $ath_tags, $start_time, $finish_time, $goal, $control, $max_laps, $bracket){
    $min_short_delta_time="00:00:03.000";
	$lap_start_time = $start_time;
	$just_before_start_time = subtract_times("00:03:00.000",$start_time);
    echo "calc_laps: $ath_bib - $ath_name - ath_tags:$ath_tags - goal:$goal - control:$control - max_laps:$max_laps<br>";
    $laps = array();
	$time_goal_f = get_athlete_first("FIRST GOAL", $dbh, $ath_tags, $goal, $just_before_start_time, $finish_time, $bracket);
    $laps_details = "";
    $end_time = "";
    if($time_goal_f){
        $end = false;
        $j=0;
        while(!$end && ++$j<50){
            $end = true;
            $time_control_f = get_athlete_first("FIRST CONTROL", $dbh, $ath_tags, $control, add_times($time_goal_f,$min_short_delta_time), $finish_time, $bracket);
            if($time_control_f){
                $time_goal_l = get_athlete_last("LAST GOAL BEFORE CONTROL", $dbh, $ath_tags, $goal, $time_goal_f, $time_control_f, $bracket);
                $time_goal_f = get_athlete_first("FIRST GOAL AFTER CONTROL", $dbh, $ath_tags, $goal, add_times($time_control_f,$min_short_delta_time), $finish_time, $bracket);
                if($time_goal_l && $time_goal_f){
                    $alap = subtract_times($time_goal_l,$time_goal_f);
                    $alap2 = subtract_times($lap_start_time,$time_goal_f);
					$lap_start_time = $time_goal_f;
                    $laps[]=$alap;
                    $laps_details = $laps_details . ";" . $alap2;
                    echo " LAP$j T".$alap." - S".$time_goal_l." C".$time_control_f." F".$time_goal_f."<br>";
                    if(count($laps) < $max_laps){
						$end = false;
						$end_time = $time_goal_f;
                    }else if(count($laps) == $max_laps){
						$end = true;
						$end_time = $time_goal_f;
                    }
                }
            }
        }
    }
	$laps_details = ltrim($laps_details, ';');
    return array($laps,$laps_details,$end_time);
}

function add_array_times($array){
    $size = count($array);
    $total_time = '00:00:00.000';
    for($i=0; $i<$size;$i++){
        $total_time= add_times($total_time,$array[$i]);
    }
    return $total_time;
}

?>
