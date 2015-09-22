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

$dr=query("SELECT *, SUM(punti) as punt, SUM(tornei) as tor FROM `tt_generale` JOIN tt_player ON tt_generale.nick = tt_player.nick LEFT JOIN tt_squadra ON tt_player.squadra = tt_squadra.nome GROUP BY tt_generale.nick order by punt desc");
$tappa=getTappa();
$odi=array();
$dr2=query("SELECT nick, punti as last FROM `tt_generale` WHERE tappa='$tappa'");
while (($h2 = mysql_fetch_assoc($dr2))) {
    $odi[$h2["nick"]]=$h2["last"];
}
//$f=addDate($INIZIO,$tappa);
$abbin = array();
$base=0;
$tra=0;
$cont=0;
while (($h = mysql_fetch_assoc($dr))) {
    $obj = new stdClass();
    $cont++;
    $obj->pos=$cont."&deg;";
    if (!isset($odi[$h["nick"]])) {
        $obj->last="";
    } else {
        $obj->last=($odi[$h["nick"]]>0)?"+".$odi[$h["nick"]]:"";
    }
    // $obj->nick=$h["nick"];
    $obj->punti=$h["punt"];
    $obj->squadra=$h["nome"];
    $obj->tornei=$h["tor"];
    $obj->status=$h["status"];
    $obj->nick2 = $h["nick"];
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
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
