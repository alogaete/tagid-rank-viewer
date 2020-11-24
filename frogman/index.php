<?php
require_once 'config.php';

$num = "";
if (array_key_exists('num', $_GET)) {
	$num = $_GET["num"];
}

$conexion = mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db(DB_NAME ,$conexion) or die("Error seleccionando la base de datos.");

if($num > 0){
   	$query = "SELECT * FROM athletes WHERE bib = '$num' LIMIT 0,1";
	mysql_query("SET NAMES utf8",$conexion) or die(mysql_error());
    $response = mysql_query($query, $conexion) or die(mysql_error());
    $row = mysql_fetch_array($response);

    $query = "SELECT count(*) FROM athletes";
    $response = mysql_query($query, $conexion) or die(mysql_error());
    list($total) = mysql_fetch_array($response);

    $query = "SELECT count(*) FROM athletes WHERE bracket = '".$row['bracket']."'";
    $response = mysql_query($query, $conexion) or die(mysql_error());
    list($categoria) = mysql_fetch_array($response);
}
?>
<html lang="es">
    <head>
        <title>Resultados</title>
        <?php if($num > 0){?> <META http-equiv="refresh" content="300;URL=<?=URL_BASE?>index.php"> <?php }?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script>
              $(document).ready(function() {
                $("#num").keydown(function (e) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                         // Allow: Ctrl+A, Command+A
                        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
                         // Allow: home, end, left, right, down, up
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                             // let it happen, don't do anything
                             return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
            });
        </script>
        <style type="text/css">
            body {
                background-color: #012547;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center top; 
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                padding:5px;
            }
            .placeholder {
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
                float: none;
                display: block;
            }
            #num {
                max-width: 150px;
                height: 80px;
                font-size: 50px;
            }
            .badge{
                font-size: 25px;
            }
            h3 {
                line-height: 1.7;
            }

            .total{
                color: rgb(51, 122, 183);
                background-color: white;
                 font-size: 32px;
            }
            .place{
                 color:  #222;
                 font-size: 32px;
				 font-weight:bolder;
				 margin-top: 0px;
				 letter-spacing: -2px;
				 font-family: Arial, Helvetica, sans-serif;
            }
            .panel-primary>.panel-heading {
                //color: #fff;
                //background-color: #c9302c;
                //border-color: #ac2925;
            }
            
        </style>
    </head>
    <body>
        <div class="container">
           <div style="width:100%; max-height:250px;">
            <img src="./img/logo.png"  class="img-responsive center-block" style="margin-top:0px; max-height:200px; margin-bottom: 10px;">
			</div>
				<h3 align="center" style="margin-top:-10px; margin-bottom:15px; color: #fff;"><?=EVENT_NAME?></h3>
            <?php if($num<=0 or  !$row ) { ?>
            <div class="row placeholder">
              <div class="col-center-block">
                    <form method="get" role="form">
                        <div class="panel panel-primary">
                          <div class="panel-heading">
                            <h2 align="center"> Revisar N&uacute;mero</h2>
                          </div>
                          <div class="panel-body">
                                <input type='number' class="form-control input-lg center-block" name="num" id="num" size="4" maxlength="4" value="<?=$num?>" autofocus="autofocus"/>
                          </div>
                          <div class="panel-footer">
                            <input class="btn btn-primary center-block btn-lg" type="submit" value="Buscar">
                          </div>
                        </div>                   
                        
                        
                    </form>
              </div>
            </div>
            <?php } else if($num>0 and  $row ) { ?>
            <center>
            
            <div class="row placeholder">
               <div class="center-block">

                    <ul class="list-group">
                        <li class="list-group-item active">
                            <h2 class="list-group-item-heading"><?=$row['bib']?> - <?=$row['name']?></h2>
                        </li>
                        <li class="list-group-item">
                            <h3 class="list-group-item-heading">Categor&iacute;a
                            <span class="label label-default"><?=$row['bracket']?></span> </h3>
                        </li>
                        
                    </ul>
                </div>
                <div class="center-block">
                     <ul class="list-group">
                        <li class="list-group-item active">
                            <h2 class="list-group-item-heading">Resultados</h2>
                        </li>
						 <li class="list-group-item">
							<h3 class="list-group-item-heading">Lugar Categor&iacute;a
							<span class="label label-default"><?=$row['bracket_rank']?$row['bracket_rank']:"-" ?> de <?=$categoria?></span> </h3>
						</li>
						<li class="list-group-item">
							<h3 class="list-group-item-heading">Cantidad Giros
							<span class="label label-default"><?=$row['laps_count']?$row['laps_count']:"-" ?></span> </h3>
						</li>
						<?php 
							$laps = explode(";", $row['laps_details']);
							$lap_names = ["Etapa A Correr Giro 1","Etapa A Correr Giro 2","Etapa A Correr Giro 3","Etapa B Nado Giro 4","Etapa C Correr Giro 5"];
							for($i=0,$l=count($laps);$i<$l && $i<5;$i++) {
								$lap = $laps[$i];
						?>
							<li class="list-group-item">
								<h3 class="list-group-item-heading"><?=$lap_names[$i]?>
								<span class="label label-default"><?=$laps[$i]?></span> </h3>
							</li>
						<?php } ?>
                        <li class="list-group-item active">
                            <h1 class="list-group-item-heading ">Tiempo
                            <span class="badge total"><?php echo $row['time']?$row['time']:"00:00:00.000";?></span></h1>
                        </li>
                    </ul>
                </div>
            
                <p>
                    <a class="btn btn-warning btn-lg center-block" role="button" href="./">Revisar Otro N&uacute;mero</a> 
                </p> 
            </div>
            <?php } ?>
            <div class="row placeholder">
                <div class="center-block">
                    <p>
                        <a class="btn btn-primary btn-lg center-block" role="button" href="rank.php"  target="_blank">Ranking</a> 
                    </p>
                </div>
            </div>
            <br/>
            <img src="img/powered.png" style="max-height:40px;" class="img-responsive center-block">
           </div>
    </body>
</html>
