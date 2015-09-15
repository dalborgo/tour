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

$dr=query("SELECT *, SUM(punti) as punt, MAX(tappa) as tp FROM `tt_pois` JOIN tt_player ON tt_pois.nick = tt_player.nick LEFT JOIN tt_squadra ON tt_player.squadra = tt_squadra.nome GROUP BY tt_pois.nick order by punt desc");


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
    // $obj->nick=$h["nick"];
    $obj->punti=$h["punt"];
    $obj->squadra=$h["nome"];
    //$obj->tornei=$h["tor"];
   // $obj->status=$h["status"];
    $obj->nick='<span class="nowr"><img style="vertical-align:middle" src="http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $h["status"]  . '.png"/> ' . $h["nick"] . '</span>';
    $abbin[]=$obj;
}
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
