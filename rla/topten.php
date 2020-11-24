<html>
<head>
<title>RLA</title>
<style type="text/css">
@font-face {
    font-family: Cut the crap;
    src: url(Cutthecrap.ttf);
}
@font-face {
    font-family: letrachica;
    src: url(book.ttf);
}
body {
    background-image: url(fondo.jpg);
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
	overflow: hidden;
}
td {
	font-size:18px;
	font-family: letrachica;
}
table{
    border-radius:5px;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
}
</style>
</head>
<body>

<script src="jquery-3.1.1.min.js"></script>
<script>
$(document).ready(function () {
	(function($){
	   var interval = 3000;  // 1000 = 1 second, 3000 = 3 seconds
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
			$(".table1").html('<tr><td colspan="10" align="center" style="font-size:36px; font-family:\'Cut the crap\';">Ranking</td></tr><tr><td style="color:FFDE0D;font-family:\'Cut the crap\';">Rank</td><td style="color:FFDE0D;font-family:\'Cut the crap\';">Bib</td><td style="color:FFDE0D;font-family:\'Cut the crap\';">Name</td><td style="color:FFDE0D;font-family:\'Cut the crap\';">Country</td><td style="color:FFDE0D;font-family:\'Cut the crap\';">Time</td><td style="color:FFDE0D;font-family:\'Cut the crap\';">Diff</td></tr>');
			for (var i = 0; i < topten.length; i++){
			  $(".table1").append("<tr><td>" + topten[i].rank + "</td><td>" + topten[i].bib + "</td><td>" + topten[i].name + "</td><td>" + topten[i].country + "</td><td>" + topten[i].time + "</td><td>" + topten[i].diff + "</td></tr>");
			}
		}
	})($);
});
</script>
<center><img src="logo.png"  style="margin-top:-15px;  height: 100px; margin-bottom:15px;"></center>
<table width="710" class="table1" style="position: relative; top: -10px; left:auto; margin: auto;background-color: rgba(0,0,0,0.7);">
</table>
<br/><br/><br/>
<center><img src="powered.png"></center>
<br/>
</body>
</html>
