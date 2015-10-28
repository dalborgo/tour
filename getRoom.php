

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
    $room="iPoker.it";
}else
    $room=$_GET['r'];

$res = query("CREATE TEMPORARY TABLE IF NOT EXISTS table3 AS (SELECT tt_dati.`nick`, SUM(guadagno) as guadagno, COUNT(*) as tornei FROM `tt_dati` WHERE network = '$room' GROUP BY nick)");

$dr=query("SELECT a.`nick`, guadagno,  tornei, maglia, status, squadra, completo FROM `table3` a LEFT JOIN tt_player b ON a.nick = b.nick LEFT JOIN tt_squadra ON b.squadra = tt_squadra.nome ORDER BY guadagno DESC, tornei desc");
$tappa=getTappa();
$dr3=query("Select SUM(guadagno) as guada, nick from tt_dati WHERE tappa = $tappa AND network = '$room' GROUP BY nick");
$yui = array();
while (($h3 = mysql_fetch_assoc($dr3))) {
    $yui[$h3["nick"]]=($h3["guada"]>=0)?'+'.$h3["guada"]:$h3["guada"];
    if($yui[$h3["nick"]]=='+0')
        $yui[$h3["nick"]]="";
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
    $obj->guadagno=$h["guadagno"];
    $obj->tornei=$h["tornei"];
    if($h["squadra"]!=null)
        $obj->squadra='<img style="vertical-align:sub" src="../shark/'.strtolower($h["squadra"]).'.png"> '.$h["completo"].'</img>';
    else
        $obj->squadra=$h["completo"];
    $obj->status=$h["status"];
    $obj->nick2 = $h["nick"];
    if(isset($yui[$h["nick"]]))
        $obj->ultimo=$yui[$h["nick"]];
    else
        $obj->ultimo="";
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
