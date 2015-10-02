


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
$res2 = query("SELECT id_torneo as id, nome, COUNT(*) cat FROM `tt_dati` WHERE tappa = '$tappa' GROUP BY id_torneo HAVING cat > 2");
$out2=array();
while (($ra2 = mysql_fetch_assoc($res2))) {
    $out2["nome"]=$ra2["nome"];
    $out2["id"]=$ra2["id"];
    $out2["categoria"]=$ra2["cat"];
    $out2["tappa"]=$tappa;
    repTV("tt_granpremi",$out2);
}
$res = query("SELECT nick, guadagno, a.tappa, categoria, a.nome, id, a.posizione, a.guadagno  FROM `tt_granpremi` b LEFT JOIN tt_dati a ON b.id = a.id_torneo AND b.tappa = a.tappa  WHERE b.tappa='$tappa' order by a.id_torneo, posizione");
$out=array();
$alta = array(15,8,5);
$media=array(7,3);
$bassa=array(4,2);
$cvi=0;
$nprec="";
$rty=array();
while (($ra = mysql_fetch_assoc($res))) {
    if($ra["id"]!=$nprec) {
        $nprec = $ra["id"];
        $cvi=0;
    }
    if($ra["categoria"]=="3")
        $rty=$bassa;
    else if ($ra["categoria"]=="4")
        $rty=$media;
    else
        $rty=$alta;
    if($cvi<count($rty) && $ra["guadagno"]>0) {
        $out["punti"] = $rty[$cvi];
        $cvi++;
    }
    else
        $out["punti"]='0';
    $out["id"]=$ra["id"];
    $out["nick"]=$ra["nick"];
    $out["nome"]=$ra["nome"];
    $out["pos"]=$ra["posizione"];
    $out["guad"]=$ra["guadagno"];
    $out["tappa"]=$tappa;
    repTV("tt_pois",$out);
}
echo "OK";

