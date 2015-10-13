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

$dr=query("SELECT *, SUM(punti) as punt, sum(case when punti > 0 then 1 else 0 end) as conto FROM `tt_pois` JOIN tt_player ON tt_pois.nick = tt_player.nick LEFT JOIN tt_squadra ON tt_player.squadra = tt_squadra.nome GROUP BY tt_pois.nick order by punt desc, conto desc");
//$dr2=query("SELECT nick, SUM(punti) as last FROM `tt_pois` WHERE tappa=3 group by nick");
$tappa=getTappa();
$odi=array();
$dr2=query("SELECT nick, SUM(punti) as last FROM `tt_pois` WHERE tappa='$tappa' group by nick");
while (($h2 = mysql_fetch_assoc($dr2))) {
    $odi[$h2["nick"]]=$h2["last"];
}
//$f=addDate($INIZIO,$tappa);
$abbin = array();
$base=0;
$tra=0;
$cont=0;
$senti=0;
$arr=maglie();
while (($h = mysql_fetch_assoc($dr))) {

    $obj = new stdClass();
    $cont++;
    $obj->pos=$cont."&deg;";
    // $obj->nick=$h["nick"];
    $obj->punti=$h["punt"];
    $obj->conto=$h["conto"];
    if (!isset($odi[$h["nick"]])) {
        $obj->last="";
    } else {
        $obj->last=($odi[$h["nick"]]>0)?"+".$odi[$h["nick"]]:"";
    }
    //$obj->last=$odi[$h["nick"]];
    //$obj->punti=$h["last"];
    $obj->squadra=$h["completo"];
    //$obj->tornei=$h["tor"];
   // $obj->status=$h["status"];
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
    $obj->nick2=$h["nick"];
    $abbin[]=$obj;
}
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
