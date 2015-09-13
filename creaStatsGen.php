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
$tappa=diffDate(date_create($INIZIO));
$res = query("CREATE TEMPORARY TABLE IF NOT EXISTS table2 AS (SELECT COUNT(*) as pres, SUM(guadagno) as guad, MAX(tappa) as tp, nick as n1 FROM tt_generale GROUP BY nick)");;

$res2 = query("SELECT s.nick, guad, pres, guadagno, tp FROM `tt_generale` s RIGHT JOIN table2 ON tappa = tp  AND s.nick = n1 ORDER BY guad desc");
$out=array();
$cont=0;
while (($ra = mysql_fetch_assoc($res2))) {
    $val=$ra["nick"];
    $status[$val] = $ra["status"];
    $under[$val] = $ra["under"];
    $squadra[$val] = $ra["squadra"];
    $lista.="$val,";
    $out["nick"]=$ra["nick"];
    $out["guadagno"]=$ra["guad"];
    $out["ultimo"]=$ra["guadagno"];
    $out["posizione"]=++$cont;
    $out["tappa"]=$tappa;
    $out["ultima_pres"]=$ra["tp"];
    if($ra["tp"]<$tappa)
        $out["ultimo"]='0';
    $out["presenze"]=$ra["pres"];
    repTV("tt_stats_gen",$out);
}