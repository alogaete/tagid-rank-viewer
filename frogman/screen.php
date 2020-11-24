<?php
require_once 'config.php';

$bracket = "Overall";
if (array_key_exists('bracket', $_GET)) {
	$bracket=$_GET['bracket'];
}

$length = 5;
if (array_key_exists('length', $_GET)) {
	$length =$_GET['length'];
}

$query = "SELECT * FROM athletes WHERE 0;";
if ($bracket != 'Overall'){
	$query = "SELECT * FROM athletes WHERE bracket = '$bracket' AND bracket_rank > 0 ORDER BY bracket_rank ASC limit $length";
}

$dbh = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME) or mysql_error($dbh);

mysql_query("SET NAMES utf8",$dbh) or die(mysql_error());
$response = mysql_query($query, $dbh) or mysql_error($dbh);

?>
<html>
    <meta http-equiv="content-language" content="es">
	<META http-equiv="refresh" content="3;URL=<?=URL_BASE?>screen.php?bracket=<?=$bracket?>">
    <head>
        <title>TAGID</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
          <script>

            $(document).ready(function() {
                $("#rankbtn").click(function (e) {
                    $("#rank").submit();
                });
                $(".find-btn").click(function (e) {
                    $("#find").submit();
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
				//transform: scale(1.5);
            }
            .placeholder {
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
                float: none;
                display: block;
            }
            #rankbtn{
                cursor: pointer;
            }
            #num {
                height: 80px;
                font-size: 50px;
            }
             .label-Primary, .panel-primary>.panel-heading,  .btn-primary, .list-group-item.active, .list-group-item.active:focus, .list-group-item.active:hover {
            }
            .badge{
                font-size: 25px;
            }
            h3 {
                line-height: 1.7;
            }

            .total{
                 font-size: 32px;
            }
            
            .panel-danger>.panel-heading {
                color: #fff;
                background-color: #c9302c;
            }

            .label{
                line-height: 26px;
            }
                        
            .bracket{
                font-size: 10px;
            }           
            .name{
                font-size: 15px;
            }
			
            a:link   
            {   
             text-decoration:none;   
            }  
			          
            .top{
                  margin-bottom: 10px;
            }
			.table>tbody>tr>td{
                  padding-top: 4px;
                  padding-bottom: 4px;
            }
			
        </style>
    </head>
    <body>
        <div class="container">
            <center>    
			<div class="row placeholder">    
            <div style="width:100%; max-height:250px; margin-bottom: 5px;">
            <img src="./img/logo.png"  class="img-responsive center-block" style="margin-top:0px; max-height:50px;">
            </div>
            <div class="row placeholder">
					
            <div class="bs-example" >
                <div class="panel panel-primary">
                    <div class="panel-heading">
						<h4><?php echo ("Overall" == $bracket ? "":"Categoría $bracket");?> </h4>
					</div>
                    <table class="table"> 
                    <thead>
                        <tr>
                            <th>Rank</th> <th>Nombre</th> <th>Giros y Tiempo</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php while($row = mysql_fetch_array($response)) { ?>
                              <tr>
                                <td class="mtd">
                                    <h4><span class="label label-default"><?php echo $row["bracket_rank"];?></span></h4>
                                </td>
                                <td class="mtd"><h4 class="top" >
                                        <a href="index.php?num=<?php echo $row["bib"];?>"><span class="name"><?=$row["bib"]?> - <?php echo strtoupper($row['name'])?></span></a>
										</h4>
                                </td>
								<td class="mtd"><h4>
                                     <span class="name"><?php echo strtoupper($row['laps_count']);?> Giros</span>
                                     <span class="label label-primary"><?php echo $row["time"]?substr($row["time"],1,-1):"0:00:00.00";?></span></h4>
                                </td>
                              </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
            <br/>
            <img src="./img/powered.png" style="max-height:20px; margin-top: -32px;"  class="img-responsive center-block">
        </div>
    </body>
</html>
