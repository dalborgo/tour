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
$dr=query("SELECT *, SUM(guadagno) as guad, SUM(tornei) as tor, under FROM `tt_generale` JOIN tt_player ON tt_generale.nick = tt_player.nick LEFT JOIN tt_squadra ON tt_player.squadra = tt_squadra.nome GROUP BY tt_generale.nick order by guad desc");
$tappa=getTappa();
$tap=$tappa-1;
$dr2=query("SELECT nick, posizione, ultimo FROM `tt_stats_gen` WHERE tappa >= '$tap' ORDER BY tappa desc");
//$f=addDate($INIZIO,$tappa);
$atr=array();
while (($o = mysql_fetch_assoc($dr2))) {
    if(array_key_exists($o["nick"],$atr)){
        $atr[$o["nick"]]->posi=$o["posizione"];
    }
    else{
        $obj2 = new stdClass();
        $obj2->ulti=$o["ultimo"];
        $atr[$o["nick"]]=$obj2;
    }

}
$abbin = array();
$base=0;
$tra=0;
$cont=0;
while (($h = mysql_fetch_assoc($dr))) {
    //$tappa=$h["tp"];
    $obj = new stdClass();
    $cont++;
    $obj->pos=$cont."&deg;";
   // $obj->nick=$h["nick"];
    if (!isset($atr[$h["nick"]]->posi)) {
        $posi="New";
    } else {
        $posi=$atr[$h["nick"]]->posi;
    }
    $ulti=($atr[$h["nick"]]->ulti>=0)?"(+ &euro;".$atr[$h["nick"]]->ulti.")":"(- &euro;".abs($atr[$h["nick"]]->ulti).")";
    if($posi=="New")
        $cumul=$posi." ".$ulti;
    else
        $cumul=$posi."&deg; ".$ulti;
    if($cont<$posi && $posi!="New")
        $obj->simb="<img src='media/images/GreenUpArrow.png' title='$cumul'>";
    else if ($cont>$posi && $posi!="New")
        $obj->simb="<img src='media/images/RedDownArrow.png' title='$cumul'>";
    else if ($posi=="New")
        $obj->simb="<img src='media/images/plus.png' title='$cumul'>";
    else
        $obj->simb="<img src='media/images/GreyNeutralArrow.png' title='$cumul'>";
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
    if($h["maglia"]!=null)
        $colore=$h["maglia"];
    else
        $colore="";
    $obj->nick='<span class="nowr '.$colore.'"><img style="vertical-align:middle" src="http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $h["status"]  . '.png"/> ' . $h["nick"] . '</span>';
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
