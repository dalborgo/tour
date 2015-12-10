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

$dr=query("SELECT
  SUM(tt_generale.punti) AS punt,
  tt_player.squadra,
  tt_squadra.completo,
  SUM(tornei) as tor
FROM tt_generale
  INNER JOIN tt_player
    ON tt_generale.nick = tt_player.nick
  RIGHT OUTER JOIN tt_squadra
    ON tt_player.squadra = tt_squadra.nome
GROUP BY tt_player.squadra order by punt DESC ");
$tappa=getTappa();
$odi=array();
$odi2=array();
$dr2=query("SELECT squadra, punti as last, tt_generale.nick, posizione FROM `tt_generale` INNER JOIN tt_player
    ON tt_generale.nick = tt_player.nick  WHERE tappa='$tappa' AND squadra IS NOT NULL ORDER BY squadra desc, punti desc");

while (($h2 = mysql_fetch_assoc($dr2))) {
    if (isset($odi[$h2["squadra"]])) {
        $odi[$h2["squadra"]] += $h2["last"];
        $odi2[$h2["squadra"]].=$h2["nick"]." (".$h2["posizione"]."&deg; +".$h2["last"].")\n";
    }
    else {
        $odi[$h2["squadra"]] = $h2["last"];
        $odi2[$h2["squadra"]]=$h2["nick"]." (".$h2["posizione"]."&deg; +".$h2["last"].")\n";
    }
}
$abbin = array();
$base=0;
$tra=0;
$cont=0;
$arr=maglie();
while (($h = mysql_fetch_assoc($dr))) {
    $obj = new stdClass();
    $cont++;
    $obj->pos=$cont."&deg;";
    if ($odi[$h["squadra"]]==0) {
        $obj->last="0";
    } else {
        $obj->last=($odi[$h["squadra"]]>0)?"+".$odi[$h["squadra"]]:"";
    }
    $obj->punti=$h["punt"];
    $obj->last="<abbr title='".$odi2[$h["squadra"]]."' class='nero'>".$obj->last."</abbr>";
    $obj->squadra=$h["squadra"];
    $obj->tornei=$h["tor"];
    $obj->nick2 = $h["completo"];
    $obj->nick='<img style="vertical-align:sub" src="../shark/'.strtolower($h["squadra"]).'.png"> '.$h["completo"].'</img>';
    $abbin[]=$obj;
}
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
