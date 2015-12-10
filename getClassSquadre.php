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

$h=query("SELECT
  tt_generale.tappa,
  tt_generale.nick,
  tt_squadra.nome,
  tt_squadra.completo,
  tt_generale.punti,
  tt_generale.tornei
FROM tt_generale
  INNER JOIN tt_player
    ON tt_generale.nick = tt_player.nick
  INNER JOIN tt_squadra
    ON tt_player.squadra = tt_squadra.nome
WHERE tt_generale.punti > 0
ORDER BY tt_generale.tappa, tt_generale.punti DESC  ");
$tappa=getTappa();
$odi=array();
$odi2=array();
$dr2=query("SELECT squadra, punti as last, tt_generale.nick, posizione FROM `tt_generale` INNER JOIN tt_player
    ON tt_generale.nick = tt_player.nick  WHERE tappa='$tappa' AND squadra IS NOT NULL ORDER BY squadra desc, punti desc");
$ls=array();
$sqp="";
//$cc=0;
while (($h2 = mysql_fetch_assoc($dr2))) {
    $ls[$h2["squadra"]]=0;//da mettere con tutte le squadre
    if($h2["squadra"]!= $sqp) {
        $cc=0;
        $sqp=$h2["squadra"];
    }
    if (isset($odi[$h2["squadra"]])) {
        if($cc > 3 && $h2["last"] > 0) {
            $fff = "- Scartato";
        }
        else {
            $fff = "";
            $odi[$h2["squadra"]] += $h2["last"];
        }
        $odi2[$h2["squadra"]].=$h2["nick"]." (".$h2["posizione"]."&deg; +".$h2["last"]." $fff)\n";
    }
    else {
        $odi[$h2["squadra"]] = $h2["last"];
        $odi2[$h2["squadra"]]=$h2["nick"]." (".$h2["posizione"]."&deg; +".$h2["last"].")\n";
    }
    $cc++;
}
$abbin = array();
$base=0;
$tra=0;
$cont2=0;
$arr=maglie();
$sq=array();
$tor=array();
$comp=array();
$tp=0;
$cont = array();
foreach ($ls as $ki => $vi) {
   // $cont[$ki] = 0;
    $sq[$ki]=0;
    $tor[$ki]=0;
}
while (($dr = mysql_fetch_assoc($h))) {
    if($dr["tappa"]!= $tp) {
        $tp=$dr["tappa"];
        foreach ($ls as $ki => $vi) {
            $cont[$ki] = 0;
        }
    }
    if ($cont[$dr["nome"]] < 4) {// max 4 player
            $sq[$dr["nome"]] += $dr["punti"];
            $tor[$dr["nome"]] += $dr["tornei"];
            $cont[$dr["nome"]]++;
            $comp[$dr["nome"]] = $dr["completo"];
    }
}
arsort($sq);
foreach ($sq as $k => $v ){
    $obj = new stdClass();
    $cont2++;
    $obj->pos=$cont2."&deg;";
    if ($odi[$k]==0) {
        $obj->last="0";
    } else {
        $obj->last=($odi[$k]>0)?"+".$odi[$k]:"";
    }
    $obj->punti=$v;
    $obj->last="<abbr title='".$odi2[$k]."' class='nero'>".$obj->last."</abbr>";
    $obj->squadra=$k;
    $obj->tornei=$tor[$k];
    $obj->nick2 = $comp[$k];
    $obj->nick='<img style="vertical-align:sub" src="../shark/'.strtolower($k).'.png"> '.$comp[$k].'</img>';
    $abbin[]=$obj;
}
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
