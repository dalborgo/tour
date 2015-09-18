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
$tappaN=diffDate2($INIZIO);
$res = query("CREATE TEMPORARY TABLE IF NOT EXISTS table2 AS (SELECT COUNT(*) as pres, SUM(guadagno) as guad, MAX(tappa) as tp, nick as n1 FROM tt_generale GROUP BY nick)");

$res2 = query("SELECT s.nick, guad, pres, guadagno, tp FROM `tt_generale` s RIGHT JOIN table2 ON tappa = tp  AND s.nick = n1 ORDER BY guad desc");
$out=array();
$out2=array();
$primo=0;$secondo=0;$terzo=0;
$mguad=-1000;
$vinci="";
$soldil=0;
$cont=0;
$cont2=0;
while (($ra = mysql_fetch_assoc($res2))) {
    //$tappa=$ra["tp"];
    $out["nick"]=$ra["nick"];
    $out["guadagno"]=$ra["guad"];
    if($ra["guadagno"]>$mguad && $ra["tp"] == $tappaN ){
        $mguad=$ra["guadagno"];
        $vinci=$ra["nick"];
    }

    if($ra["tp"] == $tappaN)
        $cont2++;
    $out["ultimo"]=$ra["guadagno"];
    $out["posizione"]=++$cont;
    if($cont==1) {
        $primo = $ra["nick"];
        $soldil=$ra["guad"];
    }
    $out["tappa"]=$tappaN;
    $out["ultima_pres"]=$ra["tp"];
    if($ra["tp"]<$tappaN)
        $out["ultimo"]='0';
    $out["presenze"]=$ra["pres"];
    repTV("tt_stats_gen",$out);
}
$resi = mysql_fetch_assoc(query("SELECT nick, SUM(punti) as p FROM `tt_pois` GROUP BY nick order by p desc LIMIT 1"));
$rtg=$resi["nick"];
$resi2 = mysql_fetch_assoc(query("SELECT a.nick, SUM(guadagno) as pu FROM `tt_generale` p JOIN tt_player a ON a.nick = p.nick WHERE under = 1 GROUP BY p.nick order by pu desc LIMIT 1"));
$rtg2=$resi2["nick"];
$resi3 = mysql_fetch_assoc(query("SELECT tt_dati.`nick`, SUM(guadagno) as guadagno  FROM `tt_dati` WHERE buyin <= 5.00 GROUP BY nick ORDER BY guadagno desc LIMIT 1"));
$rtg3=$resi3["nick"];
$res = query("UPDATE tt_tappa SET partecipanti='$cont2', leader='$primo', soldi_leader='$soldil', vincitore='$vinci', soldi = '$mguad', scalatore = '$rtg', giovane='$rtg2', inter= '$rtg3' WHERE tappa='$tappaN'");
$to["tappa"]=$tappaN+1;
repTV("tt_tappa",$to);
echo "OK";