<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Millenium</title>
    <link href="media/css/jquery.mio.css" rel="stylesheet" type="text/css">
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="media/css/bars-movie.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js" type="application/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="application/javascript"></script>
    <style>

    </style>
    <script type="text/javascript" language="javascript">
            //   function vai() {
            var table;
            var myCallback = function () {
                var json = table.ajax.json();
                $(".tempo").html(json.time);
                $(".livello").html(json.livello);
                $(".media").html(json.sm);
                $(".quanti").html(json.quanti);
            };
            $(document).ready(function () {
            table = $('#example').DataTable({
                "ajax": "getMillenium.php",
                "columns": [
                    {"data": "pos"},
                    {"data": "nick"},
                    {"data": "bui"},
                    {"data": "guadagno"},
                    {"data": "simb"},
                    {"data": "diff"}
                ],
                "aoColumnDefs": [
                    {"sClass": "center", "aTargets": [0]},
                    {"sClass": "", "aTargets": [1]},
                    {"sClass": "destra", "aTargets": [2]},
                    {"sClass": "destra", "aTargets": [3]},
                    {"sClass": "center", "aTargets": [4]},
                    {"sClass": "destra", "aTargets": [5]}
                ],
                "oLanguage": {
                    "sUrl": "./lang/ita.txt"
                },
                "paging": false,
                "bSort": false,
                "searching": false,
                "bLengthChange": false,
                "info": false,
                "fnInitComplete": function () {
                   /* var json = table.ajax.json();
                    $(".numTappa").html("Classifica Generale: " + json.tappa + "&deg; tappa (" + json.data2 + ")");
                    $(".totRac").html("Guadagno Reality: &euro; " + json.totRac);
                    */
                    myCallback();
                },
                "dom": '<"top"iflp<"clear">>rt<"bottom"il<"clear">>',
                "createdRow": function (row, data, index) {
                    var json = table.ajax.json();
                    if (data.grezzo < json.smg ) {
                        if(data.elim == 1){
                            if (index % 2 == 0)
                                $('td', row).addClass('averageMark5');
                            else
                                $('td', row).addClass('averageMark6');
                        }else {
                            if (index % 2 == 0)
                                $('td', row).addClass('averageMark');
                            else
                                $('td', row).addClass('averageMark2');
                        }
                    }else {
                        if(data.elim == 0){
                            if (index % 2 == 0)
                                $('td', row).addClass('averageMark3');
                            else
                                $('td', row).addClass('averageMark4');
                        }
                    }
                },
                "scrollCollapse": true
            });
            setInterval( function () {
                table.ajax.reload(myCallback);
            }, 30000 );
        });

    </script>
</head>
<body id="mainB" style="background-image: url('http://www.dalborgo.it/public/ss/starw7.jpg');background-position: center">


<table id="example" class="display compact" cellspacing="0" style="margin: 40px auto;width:508px;border: solid black 2px">
    <thead>
    <tr class="sopra2">
        <th colspan="3" style="padding-left: 20px;text-align:left">In Gioco: <span class="quanti"></span></th>
<!--        <th colspan="1" ><img src="media/images/mill.png" /></th>-->
        <th colspan="3" class="" style="padding-right: 20px;text-align:right">Update: <span class="tempo" style="color:#3F7FE1"></span></th>
    </tr>
    <tr class="sopra" style="background-color: ThreeDHighlight">
        <th colspan="3" class="numTappa" style="padding-left: 20px">Livello: <span class="livello" style="color:#F7731A"></span></th>
        <th colspan="3"  style="padding-right: 20px;text-align:right">Av. Stack: <span class="media" style="color:green"></span></th>
    </tr>
    <tr class="sotto">
        <th class="" style="">Pos.</th>
        <th class="sinistra" style="padding-left: 25px;width:200px">Nick</th>
        <th style="padding-right: 10px">Bui</th>
        <th style="padding-right: 10px;width:100px">Chips</th>
        <th style=""></th>
        <th style="padding-right: 10px">Differenza</th>

    </tr>
    </thead>
</table>


<script>

</script>




</body>
</html>