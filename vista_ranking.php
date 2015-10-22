<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="media/css2/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="mystyle.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js" type="application/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="application/javascript"></script>
    <script type="text/javascript" language="javascript" class="init">
        $(document).ready(function () {
            $('#exampleS').dataTable({
                "createdRow": function (row, data) {
                    if (data[2].replace(/[\$,]/g, '') * 1 < 100) {
                        $('td', row).eq(2).addClass('rosso');
                    }
                    if (data[3].replace(/[\$,]/g, '') * 1 < 50) {
                        $('td', row).eq(3).addClass('rosso');
                    }
                    if (data[4].replace(/[\$,]/g, '') * 1 < 20) {
                        $('td', row).eq(4).addClass('rosso');
                    }
                    if (data[2].replace(/[\$,]/g, '') * 1 < 80) {
                        $('td', row).eq(2).removeClass('rosso');
                        $('td', row).eq(2).addClass('arancio');
                    }
                    if (data[3].replace(/[\$,]/g, '') * 1 < 20) {
                        $('td', row).eq(3).removeClass('rosso');
                        $('td', row).eq(3).addClass('arancio');
                    }
                    if (data[4].replace(/[\$,]/g, '') * 1 < 10) {
                        $('td', row).eq(4).removeClass('rosso');
                        $('td', row).eq(4).addClass('arancio');
                    }
                    if (data[2].replace(/[\$,]/g, '') * 1 < 70) {
                        $('td', row).eq(2).removeClass('arancio');
                        $('td', row).eq(2).addClass('giallo');
                    }
                    if (data[3].replace(/[\$,]/g, '') * 1 < 12) {
                        $('td', row).eq(3).removeClass('arancio');
                        $('td', row).eq(3).addClass('giallo');
                    }
                    if (data[4].replace(/[\$,]/g, '') * 1 < 5) {
                        $('td', row).eq(4).removeClass('arancio');
                        $('td', row).eq(4).addClass('giallo');
                    }
                    if (data[2].replace(/[\$,]/g, '') * 1 < 60) {
                        $('td', row).eq(2).removeClass('giallo');
                        $('td', row).eq(2).addClass('verde');
                    }
                    if (data[3].replace(/[\$,]/g, '') * 1 < 6) {
                        $('td', row).eq(3).removeClass('giallo');
                        $('td', row).eq(3).addClass('verde');
                    }
                    if (data[4].replace(/[\$,]/g, '') * 1 < 3) {
                        $('td', row).eq(4).removeClass('giallo');
                        $('td', row).eq(4).addClass('verde');
                    }
                },
                "paging": false,
                "pagingType": "full",
                "bLengthChange": false,
                "pageLength": 30,
                "dom": '<"top"iflp<"clear">>rt<"bottom"il<"clear">>',
                "order": [[2, "desc"]],
                "scrollCollapse": true,
                "info":false,
                "oLanguage": {
                    "sUrl": "./lang/ita.txt"
                },
                columnDefs: [
                    {type: 'date-uk', targets: 0}
                ]
            });
        });
    </script>
    <style>
        .dataTables_wrapper .dataTables_filter {
            text-align: center;
        }
        .dataTables_wrapper .dataTables_filter input {
            margin-bottom: 1em;
            margin-top: 0.5em;
        }
    </style>
</head>
<body id="mainB" class="piccolo2">
<?php
include "librerie/sql.php";
include "librerie/date.php";
$res = query("SELECT r.nick AS nick, a.status AS status, r.Ability AS ability, r.AvStake AS avstake, r.AvGamesPerDay AS avpd, a.ultima AS ultima, a.squadra AS squadra, a.under AS under FROM tt_ranking AS r JOIN tt_player AS a ON r.nick = a.nick ");
$out = "";
while (($r = mysql_fetch_assoc($res))) {
    if(!isset($r["squadra"]))
        $squadra = "";
    else
        $squadra = '<img style="vertical-align:middle" src="../shark/'.strtolower($r["squadra"]).'.png"></img>';
    $out .= "<tr><td class='center'>" . $squadra . "</td>";
    $out .= "<td>" . getProf($r["nick"], $r["status"], "p") . "</td>";
    $out .= "<td class='sright'>" . $r["ability"] . "</td><td class='sright'>" . $r["avstake"] . "</td><td class='sright'>" . $r["avpd"] . "</td>";
    $fd=$r["ultima"];
    $ff=dammiData($r["ultima"]);
    if(strtotime($fd) < time() - (60*60*24*30)){
        $ff= "<span style='color:#179700;text-decoration: underline'>$ff</span>";
    }else if(strtotime($fd) < time() - (60*60*24*14)){
        $ff= "<span style='color:#179700'>$ff</span>";
    }else if(strtotime($fd) < time() - (60*60*24*7)){
        $ff= "<span style='color:#3E82CE'>$ff</span>";
    }
    $out .= "<td class='sright'>" . $ff . "</td>";
    if($r["under"]==0)
        $out .= "<td class='center'>no</td>";
    else
        $out .= "<td class='center verde'>si</td>";

    $out .= "</tr>";
}

function getProf($nome, $st, $reg)
{
    $im = ($reg == "p") ? $st : $st;
    $im .= ".png";
    return '<span class="nowr"><img style="vertical-align:middle" src="http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $im . '"/> ' . $nome . '</span>';
}

?>
<center>
<table id="exampleS" class="display compact" cellspacing="5">
    <thead>
    <tr>
        <th>Squadra</th>
        <th>Nick</th>
        <th>Abilit&agrave;</th>
        <th>&euro; Stake Medio</th>
        <th>Tornei al giorno</th>
        <th>Ultima attivit&agrave;</th>
        <th>Under</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Squadra</th>
        <th>Nick</th>
        <th>Abilit&agrave;</th>
        <th>&euro; Stake Medio</th>
        <th>Tornei al giorno</th>
        <th>Ultima attivit&agrave;</th>
        <th>Under</th>
    </tr>
    </tfoot>
    <tbody>
    <?php echo $out ?>
    </tbody>
</table>
    </center>
</body>
</html>

