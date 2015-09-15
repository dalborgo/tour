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
$tappa=diffDate2($INIZIO);
 //(nick LIKE 'Parasar' OR nick LIKE 'stardust85') AND
$res = query("SELECT tt_dati.`nick`, SUM(guadagno) as guadagno, COUNT(*) as tornei FROM `tt_dati` WHERE tappa = '$tappa' GROUP BY nick ORDER BY guadagno DESC");
$qua=mysql_num_rows($res);
$lista="";
$out=array();
$alta = array(20,17,15,13,12,10,8,6,4,3,2,1);
$media=array(15,12,10,8,6,5);
$bassa=array(6,4,2);
if($qua<7)
    $rty=$bassa;
else if ($qua<13)
    $rty=$media;
else
    $rty=$alta;
$cvi=0;
while (($ra = mysql_fetch_assoc($res))) {

    if($cvi<count($rty) && $cvi<$qua-1)
        $out["punti"]=$rty[$cvi];
    else
        $out["punti"]='0';
    $cvi++;
    $out["nick"]=$ra["nick"];
    $out["guadagno"]=$ra["guadagno"];
    $out["posizione"]=$cvi;
    $out["tappa"]=$tappa;
    $out["tornei"]=$ra["tornei"];
    repTV("tt_generale",$out);
}


