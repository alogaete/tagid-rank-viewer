<html>
<head>
<title>Valpara&iacute;so Cerro Abajo</title>
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
    overflow:hidden;
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

<script src="./jquery-3.1.1.min"></script>
<script>
(function($){
    var interval = 30000;  // 1000 = 1 second, 3000 = 3 seconds
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
        started = data.started;
        oncourse = data.oncourse;
        if(started){
            $(".oncourse").hide();
            $(".started").show();
            $("#imagen").attr("src","http://live.tagid.cl/enduro/vca/img/"+started+".png");
        }else{
            $(".started").hide();
            $(".oncourse").show();
            $(".table1").html('<tr><td colspan="10" align="center" style="font-size:36px; font-family:\'Cut the crap\';">On Course</td></tr>'
            +'<tr><td style="color:FFDE0D;font-family:\'Cut the crap\';" align= \'center\' >Bib</td>'
            +'<td style="color:FFDE0D;font-family:\'Cut the crap\';" align= \'center\' >Name</td>'
            +'<td style="color:FFDE0D;font-family:\'Cut the crap\';" align= \'center\' >Country</td>'
            +'<td style="color:FFDE0D;font-family:\'Cut the crap\';" align= \'center\' >F.Azul</td>'
            +'<td style="color:FFDE0D;font-family:\'Cut the crap\';" align= \'center\' >S.Hotel</td>'
            +'<td style="color:FFDE0D;font-family:\'Cut the crap\';" align= \'center\' >Time</td>'
            +'<td style="color:FFDE0D;font-family:\'Cut the crap\';" align= \'center\' >Rank</td>'
            +'</tr>');
            for (var i = 0; i < oncourse.length; i++){
                var color1 = oncourse[i].c1_diff.charAt(0) == '+'?"#FA8072":"#80FF00";
                var color2 = oncourse[i].c2_diff.charAt(0) == '+'?"#FA8072":"#80FF00";
                var color3 = oncourse[i].diff.charAt(0) == '+'?"#FA8072":"#80FF00";
                if(oncourse[i].c1_diff && oncourse[i].c1_diff == "0:00.00") oncourse[i].c1_diff = "";
                if(oncourse[i].c2_diff && oncourse[i].c2_diff == "0:00.00") oncourse[i].c2_diff = "";
                if(oncourse[i].c1_diff)oncourse[i].c1_diff= "<span style='font-size:12px; color:"+color1+";'><b>"+oncourse[i].c1_diff+"</b></span>";
                if(oncourse[i].c2_diff)oncourse[i].c2_diff= "<span style='font-size:12px; color:"+color2+";'><b>"+oncourse[i].c2_diff+"</b></span>";
                if(oncourse[i].diff)oncourse[i].diff= "<span style='font-size:12px;  color:"+color3+";'><b>"+oncourse[i].diff+"</b></span>";
              $(".table1").append("<tr><td align= 'center'>" + oncourse[i].bib + "</td><td align= 'center'>" + oncourse[i].name + "</td><td align='center' >" + oncourse[i].country + "</td><td align='center' >" 
              + oncourse[i].c1.substring(3) + " " + oncourse[i].c1_diff + "</td><td align= 'center' >"
              + oncourse[i].c2.substring(3) + " " + oncourse[i].c2_diff + "</td><td align= 'center' >"
              + oncourse[i].time.substring(3) + " " + oncourse[i].diff + "</td><td align='center'>"
              + oncourse[i].rank + "</td></tr>");
            }
        }
    }
})($);
</script>

    

<center><img src="logo.png"  style="margin-top:-15px;"></center>
<div class="started" >
    <table width="710" class="table2" style="position: relative; top: -10px; left:auto; margin: auto;background-color: rgba(0,0,0,0.7);">
        <tr>
            <td colspan="10" align="center" style="font-size:36px; font-family:'Cut the crap';">
                <div  style="position: relative; z-index:10; position: relative;">Started</div>
                <div  style="position: relative; z-index:9; margin-top: -40px; "><img src="" id="imagen"></div>
            </td>
        </tr>
    </table>
</div>
<div class="oncourse">
    <table width="710" class="table1" style="position: relative; top: -10px; left:auto; margin: auto;background-color: rgba(0,0,0,0.7);"></table>
</div>
<br/><br/><br/>
<center><img src="powered.png"></center>
<br/>
</body>
</html>
