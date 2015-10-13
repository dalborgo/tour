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
if (!isset($_GET['r']) || $_GET['r']=="")
{
    $room=1;
}else
    $tappa=$_GET['r'];
$dr=query("SELECT * FROM `tt_generale` JOIN tt_player ON tt_generale.nick = tt_player.nick LEFT JOIN tt_squadra ON tt_player.squadra = tt_squadra.nome WHERE tappa='$tappa' order by posizione, tornei desc");

$dr2=mysql_fetch_array(query("SELECT descrizione, combat, tipo, diff FROM tt_tappa WHERE tappa ='$tappa'"));
//$f=addDate($INIZIO,$tappa);
$abbin = array();
$base=0;
$tra=0;
$cont=0;
$arr=maglie();
while (($h = mysql_fetch_assoc($dr))) {
    $obj = new stdClass();
    $cont++;
    $obj->pos=$cont."&deg;";
    // $obj->nick=$h["nick"];
    $tra+=$h["guadagno"];

    $obj->guadagno=$h["guadagno"];
    $obj->squadra=$h["completo"];
    $obj->tornei=$h["tornei"];
    $obj->punti=$h["punti"];
    //$obj->distacco=($base-$h["guad"]==0)?"":"-".($base-$h["guad"]);
    $obj->status=$h["status"];
    $obj->nick2=$h["nick"];
    $m="";$colore2="";$colore="";
    if(array_key_exists($h["nick"],$arr)) {
        $m = $arr[$h["nick"]];
        foreach ($m as $k => $v)
                $colore2.="<img class='maglia' src='media/images/$v.png'/>";
        $colore="bold";
    }else
        $colore2="";
    $obj->nick='<span class="nowr '.$colore.'"><img style="vertical-align:middle" src="http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $h["status"]  . '.png"/> ' . $h["nick"] . '</span>
    '.$colore2;
    $abbin[]=$obj;
}
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->totRac = $tra;
$usc2->tipo = $dr2["tipo"];
if($dr2["diff"]<3.4)
    $cf="Facile";
else if ($dr2["diff"]<3.8)
    $cf="Normale";
else if ($dr2["diff"]<4.2)
    $cf="Impegnativa";
else if ($dr2["diff"]<4.6)
    $cf="Difficile";
else
    $cf="Folle";
$usc2->diff = $cf;
$usc2->diff2 = $dr2["diff"];
$usc2->combat = $dr2["combat"];
$usc2->partecipanti = $cont;
$usc2->data2 = addDate($INIZIO,$tappa);
$usc2->desc = $dr2["descrizione"];
echo json_encode($usc2);
