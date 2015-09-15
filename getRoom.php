

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 11/09/2015
 * Time: 03:11
 */
include_once "librerie/sql.php";
include_once "librerie/date.php";
include_once "librerie/specific.php";
if (!isset($_GET['r']) || $_GET['r']=="")
{
    $room="iPoker.it";
}else
    $room=$_GET['r'];

//$tappa=diffDate2($INIZIO);
$res = query("CREATE TEMPORARY TABLE IF NOT EXISTS table3 AS (SELECT tt_dati.`nick`, SUM(guadagno) as guadagno, COUNT(*) as tornei, MAX(tappa) as tp FROM `tt_dati` WHERE network = '$room' GROUP BY nick)");

$dr=query("SELECT a.`nick`, guadagno,  tornei, status,tp, squadra FROM `table3` a LEFT JOIN tt_player b ON a.nick = b.nick  ORDER BY guadagno DESC");

//$f=addDate($INIZIO,$tappa);
$abbin = array();
$base=0;
$tra=0;
$cont=0;
while (($h = mysql_fetch_assoc($dr))) {
    $tappa=$h["tp"];
    $obj = new stdClass();
    $cont++;
    $obj->pos=$cont."&deg;";
    $obj->guadagno=$h["guadagno"];
    $obj->tornei=$h["tornei"];
    $obj->squadra=$h["squadra"];
    $obj->status=$h["status"];
    $obj->nick2 = $h["nick"];
    $obj->nick='<span class="nowr"><img style="vertical-align:middle" src="http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $h["status"]  . '.png"/> ' . $h["nick"] . '</span>';
    $abbin[]=$obj;
}
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
