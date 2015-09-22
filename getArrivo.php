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
$tappa=getTappa();
$dr=query("SELECT * FROM `tt_generale` JOIN tt_player ON tt_generale.nick = tt_player.nick LEFT JOIN tt_squadra ON tt_player.squadra = tt_squadra.nome WHERE tappa='$tappa' order by guadagno desc");

$dr2=mysql_fetch_array(query("SELECT descrizione, combat, tipo, diff FROM tt_tappa WHERE tappa ='$tappa'"));
//$f=addDate($INIZIO,$tappa);
$abbin = array();
$base=0;
$tra=0;
$cont=0;
while (($h = mysql_fetch_assoc($dr))) {
    $obj = new stdClass();
    $cont++;
    $obj->pos=$h["posizione"]."&deg;";
    // $obj->nick=$h["nick"];
    $tra+=$h["guadagno"];
    $obj->guadagno=$h["guadagno"];
    $obj->squadra=$h["nome"];
    $obj->tornei=$h["tornei"];
    $obj->punti=$h["punti"];
    //$obj->distacco=($base-$h["guad"]==0)?"":"-".($base-$h["guad"]);
    $obj->status=$h["status"];
    $obj->nick2=$h["nick"];
    if($h["maglia"]!=null)
        $colore=$h["maglia"];
    else
        $colore="";
    $obj->nick='<span class="nowr '.$colore.'"><img style="vertical-align:middle" src="http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $h["status"]  . '.png"/> ' . $h["nick"] . '</span>';
    $abbin[]=$obj;
}
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->totRac = $tra;
$usc2->tipo = $dr2["tipo"];
$usc2->diff = $dr2["diff"];
$usc2->combat = $dr2["combat"];
$usc2->partecipanti = $cont;
$usc2->data2 = addDate($INIZIO,$tappa);
$usc2->desc = $dr2["descrizione"];
echo json_encode($usc2);
