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
$dr=query("SELECT *, SUM(guadagno) as guad, SUM(apremio) as itm, SUM(tornei) as tor, under FROM `tt_generale` JOIN tt_player ON tt_generale.nick = tt_player.nick LEFT JOIN tt_squadra ON tt_player.squadra = tt_squadra.nome GROUP BY tt_generale.nick order by guad desc, tor desc");
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
$arr=maglie();
while (($h = mysql_fetch_assoc($dr))) {
    //$tappa=$h["tp"];
    $obj = new stdClass();
    $cont++;
    $obj->pos=$cont."&deg;";
    $obj->itm=number_format($h["itm"]*100/$h["tor"],1);
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
    if($h["squadra"]!=null)
        $obj->squadra='<img style="vertical-align:sub" src="../shark/'.strtolower($h["squadra"]).'.png"> '.$h["completo"].'</img>';
    else
        $obj->squadra=$h["completo"];
    $obj->tornei=$h["tor"];
    $sott=number_format($base-$h["guad"],2);
    $obj->distacco=($sott==0)?"":"-".($sott);
    $obj->status=$h["status"];
    $obj->under = $h["under"];
    $obj->nick2 = $h["nick"];
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
$dr2=mysql_fetch_array(query("SELECT giovane FROM tt_tappa WHERE tappa ='$tappa'"));
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->totRac = number_format($tra,2);
$usc2->giovane = $dr2["giovane"];
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
