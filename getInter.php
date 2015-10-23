

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

if (!isset($_GET['r']) || $_GET['r']=="")
{
    $buy="5";
}else
    $buy=$_GET['r'];
$tappa=getTappa();
//$tappa=diffDate2($INIZIO);
if($buy=="0") {
    $res = query("CREATE TEMPORARY TABLE IF NOT EXISTS table4 AS (SELECT tt_dati.`nick`, SUM(guadagno) as guadagno,SUM(if(guadagno > 0.00, 1, 0)) as itm, COUNT(*) as tornei FROM `tt_dati` WHERE buyin <= $buy
AND entranti >=450
AND nome NOT LIKE '%9000 FPP%'
AND nome NOT LIKE '%1000 FPP%'
AND nome NOT LIKE '%SilverStar+ VIP Privilege%'
AND nome NOT LIKE '%GoldStar+ VIP Privilege%'
AND nome NOT LIKE '%All-In Shootout%'
AND nome NOT LIKE '%Depositor%'
GROUP BY nick)");
$dr3=query("Select SUM(guadagno) as guada, nick from tt_dati WHERE tappa = $tappa AND buyin <= $buy
    AND entranti >=450
    AND nome NOT LIKE '%9000 FPP%'
    AND nome NOT LIKE '%1000 FPP%'
    AND nome NOT LIKE '%SilverStar+ VIP Privilege%'
    AND nome NOT LIKE '%GoldStar+ VIP Privilege%'
    AND nome NOT LIKE '%All-In Shootout%'
    AND nome NOT LIKE '%Depositor%'
GROUP BY nick");

}
else {
    $res = query("CREATE TEMPORARY TABLE IF NOT EXISTS table4 AS (SELECT tt_dati.`nick`, SUM(guadagno) as guadagno, SUM(if(guadagno > 0, 1, 0)) as itm, COUNT(*) as tornei FROM `tt_dati` WHERE buyin <= $buy GROUP BY nick)");
    $dr3=query("Select SUM(guadagno) as guada, nick from tt_dati WHERE tappa = $tappa AND buyin <= $buy GROUP BY nick");
}

$dr=query("SELECT a.`nick`, guadagno,  tornei, status, squadra, maglia, itm, completo FROM `table4` a LEFT JOIN tt_player b ON a.nick = b.nick LEFT JOIN tt_squadra ON b.squadra = tt_squadra.nome ORDER BY guadagno DESC, tornei desc");

//$f=addDate($INIZIO,$tappa);
$abbin = array();
$base=0;
$tra=0;
$cont=0;

$yui = array();
while (($h3 = mysql_fetch_assoc($dr3))) {
    $yui[$h3["nick"]]=($h3["guada"]>=0)?'+'.$h3["guada"]:$h3["guada"];
    if($yui[$h3["nick"]]=='+0')
        $yui[$h3["nick"]]="";
}
$arr=maglie();
while (($h = mysql_fetch_assoc($dr))) {
    $obj = new stdClass();
    $cont++;
    $obj->pos=$cont."&deg;";
    $obj->guadagno=$h["guadagno"];
    $obj->itm=number_format($h["itm"]*100/$h["tornei"],1);
    $obj->tornei=$h["tornei"];
    if($h["squadra"]!=null)
        $obj->squadra='<img style="vertical-align:sub" src="../shark/'.strtolower($h["squadra"]).'.png"> '.$h["completo"].'</img>';
    else
        $obj->squadra=$h["completo"];
    $obj->status=$h["status"];
    if(isset($yui[$h["nick"]]))
        $obj->ultimo=$yui[$h["nick"]];
    else
        $obj->ultimo="";
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
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
