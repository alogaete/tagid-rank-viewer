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

<script src="jquery-1.10.2.js" type="text/javascript" language="javascript"></script>
<script>
	$(document).ready(function () {
	// ===================================
	//http://45.56.121.235/rla/raceday_screen/results.php?displayLength=10&race=Completa40K&eventID=35056&bracket=GeneralVarones&title=Hola%20amigos
	//
		var QueryString = function () {
			  // This function is anonymous, is executed immediately and 
			  // the return value is assigned to QueryString!
			  var query_string = {};
			  var query = window.location.search.substring(1);
			  var vars = query.split("&");
			  for (var i=0;i<vars.length;i++) {
			    var pair = vars[i].split("=");
			    	// If first entry with this name
			    if (typeof query_string[pair[0]] === "undefined") {
			      query_string[pair[0]] = pair[1];
			    	// If second entry with this name
			    } else if (typeof query_string[pair[0]] === "string") {
			      var arr = [ query_string[pair[0]], pair[1] ];
			      query_string[pair[0]] = arr;
			    	// If third or later entry with this name
			    } else {
			      query_string[pair[0]].push(pair[1]);
			    }
			  } 
			    return query_string;
			} ();
			
		var displayLength = 5;
		if(QueryString.displayLength){
			displayLength = QueryString.displayLength;
		}
		
		$(document).on( 'click', '.toggle-print', function(){$('.controles').toggle();});
	
		$(document).on( 'click', '.toggle', function(){
			$(this).next().toggle();
			$(this).toggle();
		});
		
		var raceID = "";
		var bracketId = "";
		var j = 0;
		
		var getBracket = function (){
			console.log("getBracket");
			$.ajax({
				url: 'http://results.chronotrack.com/embed/results/results-grid?iDisplayLength='+displayLength+'&eventID='+ QueryString.eventID +'&raceID='+raceID+'&bracketID='+ bracketId,
				data: '',
				type: 'GET',
				crossDomain: true,
				dataType: 'jsonp',
				success: function(json){
					console.log(json);
					console.log('j'+j++);
					var row = $('<tr></tr>').html('<td style="color:FFDE0D;font-family:\'Cut the crap\';">Rank</td><td style="color:FFDE0D;font-family:\'Cut the crap\';">Bib</td><td style="color:FFDE0D;font-family:\'Cut the crap\';">Name</td><td style="color:FFDE0D;font-family:\'Cut the crap\';">Time</td><td style="color:FFDE0D;font-family:\'Cut the crap\';">Pace (Km/h)</td>')
					
					$('.table'+bracketId).html('');
					$('.table'+bracketId).append(row);
					for (var i = 0; i < json.aaData.length; i++) {
						var row = $('<tr></tr>').html('<td>'+(i+1)+'</td>'+'<td>'+json.aaData[i][3]+'<td>'+json.aaData[i][2].toUpperCase()+'</td><td>'+json.aaData[i][4]+'</td><td>'+json.aaData[i][5]+'</td>')
						$('.table'+bracketId).append(row);
					}
				},
				complete: function (data) {
					setTimeout(getBracket, 3000);
				},
				error: function() { alert('Failed!'); }
			});
		}
		
		$.ajax({
			url: 'http://results.chronotrack.com/embed/results/load-model?modelID=event&eventID='+ QueryString.eventID,
			data: '',
			type: 'GET',
			crossDomain: true,
			dataType: 'jsonp',
			success: function (data) {
				$.each(data.model.races, function(ind, item) {
					if (decodeURI(QueryString.race) != item.name) return;
					
					for (var i = 0; i < item.brackets.length; i++) {

						var selectedBracket = decodeURI(QueryString.bracket);
						if(item.brackets[i].name != selectedBracket) continue;
						
						var title = 'Ranking ' + item.brackets[i].name;
						if (QueryString.title != null) title = decodeURI(QueryString.title);
						var table1 = $('<table></table>');
						table1.append('<tr><td colspan="6" align="center" style="font-size:36px; font-family:\'Cut the crap\';">' + title +'</td></tr><tr>');
						$('.p-content').append(table1);
					
						var table = $('<table cellspacing="7"></table>').addClass('table'+item.brackets[i].id);
						$('.p-content').append(table);
						raceID = item.id;
						bracketId = item.brackets[i].id;
						getBracket();
					}
					
				});					
			},
			error: function() { 
				alert('Failed!'); 
			}
		});
	});
		
</script>
<center><img src="logo.png"  style="margin-top:-15px;  height: 150px; margin-bottom:15px;"></center>
<center>
	<div width="710" class="p-content" style="position: relative; top: -10px; left:auto; margin: auto;background-color: rgba(0,0,0,0.8);"></div>
</center>
<center><img src="powered.png" style="height: 25px;"></center>
<br/>
</body>
</html>
