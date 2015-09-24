<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 15/09/2015
 * Time: 10:12
 */

include "librerie/sql.php";
include "librerie/specific.php";
echo getTappa();
/*
$tu = query("SELECT nick, maglia FROM `tt_player` WHERE maglia IS NOT NULL");
$arr=array();
while (($q = mysql_fetch_assoc($tu))) {
    $arr[$q["nick"]]=explode(',',$q["maglia"]);
}
print_r($arr);


$inizio="Sep 13 2015";
//$interval=diffDate2($INIZIO);
//$dateW2 = new DateTime('06/31/2011');
//is_localhost();
//echo $_SERVER['SERVER_NAME'];
if (!isset($_SERVER['HTTP_HOST'])) {
    $actual_link = "";
} else {
    $actual_link = $_SERVER['HTTP_HOST'];
}

if($actual_link=="www.dalborgo.com")
    echo "go";
//$esc=getIntervallo($INIZIO);
$date = new DateTime();
$format=$date->format('Y-m-d');
$seco=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $format) ) ));
$intervallo=diffDate2($inizio);
$out[0]=$intervallo;
$out[1]=strtotime($seco);
$out[2]=strtotime($format);
$tappa=$out[0];
//print_r($out);

$primo="thecogo";
$respi = mysql_fetch_assoc(query("SELECT nick, SUM(punti) as p FROM `tt_generale` GROUP BY nick order by p desc LIMIT 1"));
$rtgp=$respi["nick"];
$resi = mysql_fetch_assoc(query("SELECT nick, SUM(punti) as p FROM `tt_pois` GROUP BY nick order by p desc LIMIT 1"));
$rtg=$resi["nick"];
$resi2 = mysql_fetch_assoc(query("SELECT a.nick, SUM(guadagno) as pu FROM `tt_generale` p JOIN tt_player a ON a.nick = p.nick WHERE under = 1 GROUP BY p.nick order by pu desc LIMIT 1"));
$rtg2=$resi2["nick"];
$resi3 = mysql_fetch_assoc(query("SELECT tt_dati.`nick`, SUM(guadagno) as guadagno  FROM `tt_dati` WHERE buyin <= 5.00 GROUP BY nick ORDER BY guadagno desc LIMIT 1"));
$rtg3=$resi3["nick"];
$rew = query("SELECT nick, maglia FROM tt_player");
while (($j = mysql_fetch_assoc($rew))) {
    $n=$j["nick"];
    $m=$j["maglia"];
    $stot="";
    if($n==$primo){
        $c="gialla";
        $stot.=$c.",";
    }
    if($n==$rtgp){
        $c="verde";
        $stot.=$c.",";
    }
    if($n==$rtg){
        $c="pois";
        $stot.=$c.",";
    }
    if($n==$rtg3){
        $c="blu";
        $stot.=$c.",";
    }
    if($n==$rtg2){
        $c="bianca";
        $stot.=$c.",";
    }
    $stot=togliUltimo($stot);
    if($stot=="")
        echo $n." miemte\n";
    else
        echo $n." ".$stot."\n";
}
*/