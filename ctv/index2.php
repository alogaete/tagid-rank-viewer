<?php

$db = "tagid_vicuna";
$user = "root";
$pass = "linode..-+-+33";
$host = "localhost";

$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);
mysql_query("SET NAMES utf8",$dbh) or die(mysql_error());


$aths = array();
$q = "SELECT * FROM athletes ORDER BY bib ASC";
$response = mysql_query($q, $dbh) or mysql_error($dbh);
while($row = mysql_fetch_array($response)) {
	$tags = explode(";", $row['tags']);
	
	for($i = 0; $i < count($tags); $i++){
		$tag = $tags[$i];
		$aths[$tag] = array(
			'name' => $row['name'],
			'bib' => $row['bib']
		);
	}
}


$result = array();
$j = 0;
$q = "SELECT tag, time FROM times ORDER BY time DESC LIMIT 10";
$response = mysql_query($q, $dbh) or mysql_error($dbh);
while($row = mysql_fetch_array($response)) {
	$tag = $row['tag']."";
	$ath = $aths[$tag];
	
	$result[$j++] = array(
		'name' => $ath['name'],
		'bib' => $ath['bib'],
		'tag' => $row['tag'],
		'time' => substr(explode(" ", $row['time'])[1],0,-4)
	);
}
?>

<html>
    <meta http-equiv="content-language" content="es">
	<META http-equiv="refresh" content="3;URL=./">
    <head>
        <title>TAGID</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
          <script>
           
        </script>
        <style type="text/css">
            body {
                background-color: #000;
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
        </style>
    </head>
    <body>
        <div class="container">
            <center>    
			<div class="row placeholder">    
            <div style="width:100%; max-height:250px;">
            <img src="./img/logo.png"  class="img-responsive center-block" style="margin-top:0px; max-height:200px;">
            </div>
			<br>
            <div class="row placeholder">
            <div class="bs-example" >
                <div class="panel panel-primary">
                    <div class="panel-heading">
						<h4>LLegando a Meta</h4>
					</div>
                    <table class="table"> 
                    <thead>
                        <tr>
                            <th>Hora</th> <th>Bib</th> <th>Nombre</th>
                        </tr>
                    </thead>
                        <tbody>
                            <?php for($i = 0; $i < count($result); $i++){ ?>
                              <tr>
                                <td><h4><span class="label label-default"><?php  echo $result[$i]["time"]; ?></span></h4></td>
                                <td><h4 class="top" ><?php echo $result[$i]["bib"]; ?></h4></td>
								<td><h4 class="top" ><span class="name"><?php echo strtoupper($result[$i]['name']); ?></span></td>
                              </tr>
                            <?php }?>
                            </tr>
                        </tbody>
                    </table>
                </div> 
            </div>
            </div>
            <br/>
            <img src="./img/powered.png" style="max-height:40px;"  class="img-responsive center-block">
        </div>
    </body>
</html>
