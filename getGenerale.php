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
$dr=query("SELECT *, SUM(guadagno) as guad, MAX(tappa) as tp, SUM(tornei) as tor, under FROM `tt_generale` JOIN tt_player ON tt_generale.nick = tt_player.nick LEFT JOIN tt_squadra ON tt_player.squadra = tt_squadra.nome GROUP BY tt_generale.nick order by guad desc");

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
    if($cont==1)
        $base=$h["guad"];
    $tra+=$h["guad"];
    $obj->guadagno=$h["guad"];
    $obj->squadra=$h["nome"];
    $obj->tornei=$h["tor"];
    $obj->distacco=($base-$h["guad"]==0)?"":"-".($base-$h["guad"]);
    $obj->status=$h["status"];
    $obj->under = $h["under"];
    $obj->nick2 = $h["nick"];
    $obj->nick='<span class="nowr"><img style="vertical-align:middle" src="http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $h["status"]  . '.png"/> ' . $h["nick"] . '</span>';
    $abbin[]=$obj;
}
$dr2=mysql_fetch_array(query("SELECT giovane FROM tt_tappa WHERE tappa ='$tappa'"));
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->totRac = $tra;
$usc2->giovane = $dr2["giovane"];
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
