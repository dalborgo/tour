<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 10/09/2015
 * Time: 15:27
 */
//require "simple_html_dom.php";
include "librerie/fetch.php";
include "librerie/sql.php";
include "librerie/specific.php";
include "librerie/date.php";
include "librerie/stringhe.php";
$m=array();
$a=array();
$o=array();
$o=vai("gp","gt", "gialla", 200, $a, $m);
$o=vai("vp","vt", "verde", 100, $o[0], $o[1]);
$o=vai("pp","pt", "pois", 100, $o[0], $o[1]);
$o=vai("ap","at", "azzurra", 100, $o[0], $o[1]);
$o=vai("magop","magot", "freeroll", 100, $o[0], $o[1]);
$o=vai("ipp","ipt", "ipoker", 50, $o[0], $o[1]);
$o=vai("psp","pst", "ps", 50, $o[0], $o[1]);
$o=vai("pap","pat", "party", 30, $o[0], $o[1]);
$o=vai("pcp","pct", "pclub", 30, $o[0], $o[1]);
$o=vai("acp","act", "active", 20, $o[0], $o[1]);
$o=vai("microp","microt", "microgame", 40, $o[0], $o[1]);
$o=vai("tappep","tattet", "vittorie", 100, $o[0], $o[1]);
$o=vai("comp","comt", "combat", 100, $o[0], $o[1]);
$o=vai("postp","postt", "post", 150, $o[0], $o[1]);
$o=vai("sqp","sqt", "clsqua", 100, $o[0], $o[1]);
$bianca=mysql_fetch_assoc(query("SELECT
  tt_player.nick
FROM tt_player
WHERE tt_player.maglia IN ('bianca')"));
print_r($o[1]);
$s=$o[1];
foreach ($o[0] as $k => $v) {
    if(!isset($v["gp"]))
        continue;
    $v["nick"]=$k;
    $v["bonusm"]=0;
    if(isset($o[2][$k]))
        $v["squadra"]=$o[2][$k];
    if($k==$s[0])
        $v["bonusm"]+=50;
    if($k==$s[1])
        $v["bonusm"]+=30;
    if($k==$s[2])
        $v["bonusm"]+=30;
    if($k==$s[3])
        $v["bonusm"]+=30;
    if($k==$s[4])
        $v["bonusm"]+=30;
    if($k==$s[5])
        $v["bonusm"]+=20;
    if($k==$s[6])
        $v["bonusm"]+=20;
    if($k==$s[7])
        $v["bonusm"]+=20;
    if($k==$s[8])
        $v["bonusm"]+=20;
    if($k==$s[9])
        $v["bonusm"]+=20;
    if($k==$s[10])
        $v["bonusm"]+=20;
    if($k==$bianca["nick"])
        $v["bonusm"]+=30;
    if(isset($o[2][$k]))
        if($o[2][$k]==$o[3])
            $v["bonusm"]+=30;
    $v["totale"]=$v["bonusm"]
        +$v["postt"]
        +$v["sqt"]
        +$v["microt"]
        +$v["pct"]
        +$v["pat"]
        +$v["act"]
        +$v["ipt"]
        +$v["gt"]
        +$v["vt"]
        +$v["pt"]
        +$v["at"]
        +$v["comt"]
        +$v["tattet"]
        +$v["magot"]
        +$v["pst"];
    repTV("tt_reality",$v);
}

function vai($e1, $e2, $tab, $t, $a, $m){
    $res2 = query("SELECT * from $tab ORDER BY guadagno desc");
    $cont=0;$max=0;$comp=array();$sqv='';
    while (($ra = mysql_fetch_assoc($res2))) {
        if($cont++==0) {
            $max = $ra["guadagno"];
            $m[]=$ra["nick"];
            if(isset($ra["completo"]))
                $sqv=$ra["completo"];
        }
        if(isset($ra["completo"]))
            $comp[$ra["nick"]]=$ra["completo"];
        $a[$ra["nick"]][$e1]=$ra["guadagno"];
        $a[$ra["nick"]][$e2]=tot($ra["guadagno"],$max,$t);
    }
    return array($a,$m,$comp,$sqv);
}

function tot($v, $m, $p){
    return round($v*$p/$m).'';
}