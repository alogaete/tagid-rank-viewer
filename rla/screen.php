<?php
$db="tagid_rla";
$user="root";
$pass="linode..-+-+33";
$host="localhost";

$query = "SELECT * FROM athletes WHERE lugar_general > 0 ORDER BY lugar_general ASC";
$dbh = mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_select_db($db) or mysql_error($dbh);
$resp = mysql_query($query, $dbh) or mysql_error($dbh);

?>
<html>
<head>
<title>RLA</title>
<style type="text/css">
@font-face {
    font-family: Cut the crap;
    src: url(Cutthecrap.ttf);
}
body {
    background-image: url(fondo.jpg);
    background-size:cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center top; 
	 -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	font-family: Trebuchet MS;
	color:#fff;
	font-size:22px;
    overflow:hidden;
}
td {
	font-size:18px;
}
.table1{
    border-radius:10px;
    -moz-border-radius:10px;
    -webkit-border-radius:10px;
    position: absolute;
    top: 30px;
    left: 5px;
    width: 550px;
    background-color: rgba(0,0,0,0.7);
    height:99%;
}
.table2{
    border-radius:10px;
    -moz-border-radius:10px;
    -webkit-border-radius:10px;
    position: absolute;
    top: 30px;
    right: 5px;
    width: 550px;
    background-color: rgba(0,0,0,0.7);
    height:99%;
}
.center{
    border-radius:10px;
    -moz-border-radius:10px;
    -webkit-border-radius:10px;
    position: absolute;
    top: 10px;
    left: 5px;
    width: 550px;
    background-color: rgba(0,0,0,0.7);
}
</style>
</head>
<body>

<script src="./jquery-3.1.1.min.js"></script>
<script>
(function($){
   var interval = 1000;  // 1000 = 1 second, 3000 = 3 seconds
    function doAjax() {
        $.ajax({
                type: 'POST',
                url: 'json.php',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (data) {
                    process(data);
                },
                complete: function (data) {
                    setTimeout(doAjax, interval);
                }
        });
    }
    setTimeout(doAjax, interval);
    function process(data) {
        console.log(data);
        topten = data.topten;
        $(".table1").html('<tr><td colspan="10" align="center" style="font-size:42px; font-family:\'Cut the crap\';">Top Ten</td></tr><tr><td style="color:ff0000;">Place</td><td style="color:ff0000;">Bib</td><td style="color:ff0000;">Name</td><td style="color:ff0000;">Country</td><td style="color:ff0000;">Time</td><td style="color:ff0000;">Diff</td></tr>');
        for (var i = 0; i < topten.length; i++){
          $(".table1").append("<tr><td>" + topten[i].place + "</td><td>" + topten[i].bib + "</td><td>" + topten[i].name + "</td><td>" + topten[i].country + "</td><td>" + topten[i].time + "</td><td>" + topten[i].diff + "</td></tr>");
        }
        
        topten = data.topten;
        $(".table2").html('<tr><td colspan="10" align="center" style="font-size:42px; font-family:\'Cut the crap\';">On Course</td></tr><tr><td style="color:ff0000;">Place</td><td style="color:ff0000;">Bib</td><td style="color:ff0000;">Name</td><td style="color:ff0000;">Country</td><td style="color:ff0000;">Time</td><td style="color:ff0000;">Diff</td></tr>');
        for (var i = 0; i < topten.length; i++){
          $(".table2").append("<tr><td>" + topten[i].place + "</td><td>" + topten[i].bib + "</td><td>" + topten[i].name + "</td><td>" + topten[i].country + "</td><td>" + topten[i].time + "</td><td>" + topten[i].diff + "</td></tr>");
        }
    }
})($);
</script>

<div style="position: relative; height:100%; width:100%;" >

<br><br><br><br><br><br><br><br><br>
<img src="logo.png" width="220px"  style="display:block; margin:auto; padding:auto;">
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<center><img src="powered.png" width="100px" style="bottom: 10px;" ></center>
</div>
<table width="900" class="table1">
<tr>
	<td colspan="10" align="center" style="font-size:42px">Top Ten</td>
</tr>
<tr>
    <td style="color:ff0000;">Place</td>
    <td style="color:ff0000;">Bib</td>
    <td style="color:ff0000;">Name</td>
    <td style="color:ff0000;">Country</td>
    <td style="color:ff0000;">Time</td>
    <td style="color:ff0000;">Diff</td></tr>

</table>

<table width="900" class="table2">
<tr>
	<td colspan="10" align="center" style="font-size:42px">On Course</td>
</tr>
<tr>
    <td style="color:ff0000;">Place</td>
    <td style="color:ff0000;">Bib</td>
    <td style="color:ff0000;">Name</td>
    <td style="color:ff0000;">Country</td>
    <td style="color:ff0000;">Time</td>
    <td style="color:ff0000;">Diff</td></tr>
</table>
<br/>
</body>
</html>
