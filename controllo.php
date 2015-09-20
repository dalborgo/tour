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
//1442214000~1442300400


if (!isset($_GET['a']) || !isset($_GET['b']) || !isset($_GET['c']))
{
    $format="2015-09-14";
    $seco=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $format) ) ));
    $_GET['a']=strtotime($seco . '09:00:00');
    $_GET['b']=strtotime($format . '08:59:59');
    $value="Bosca95";
    $ore = $_GET['a'] . "~" . $_GET['b'];
}else {
    $ore = $_GET['a'] . "~" . $_GET['b'];
    $value=$_GET['c'];
}

echo date('d/m/Y H:i', $_GET['a'])."<br>";
echo date('d/m/Y H:i', $_GET['b'])."<br>";
//$ore=$esc[1]."~".$esc[2]; //1442214000~1442300399
$res= array();
//$value=$_GET['c'];
$ecco=array();
$reso = query("SELECT * FROM `tt_dati` WHERE nick LIKE '$value'");
while (($ra = mysql_fetch_assoc($reso))) {
    $val=$ra["id_torneo"];
    $ecco[$val] = $ra["nome"];
}
echo " CONTA :".count($ecco);
$res[$value] = ccall('http://www.sharkscope.com/api/dalborgo/networks/PlayerGroup/players/'.$value.'/completedTournaments?order=Last,50&filter=Date:'.$ore.';Class:SCHEDULED');//TournamentName:explosive;

$usc=array();
$err=array();
$atos=array();
$errC=array();
foreach ($res as $key2 => $value2) {

    //$gioc2=$value2->Response->PlayerResponse->PlayerView;
    if(!isset($value2->Response->PlayerResponse->PlayerView->PlayerGroup->CompletedTournaments->Tournament))
        continue;
    else
        $gioc2=$value2->Response->PlayerResponse->PlayerView;

    foreach ($gioc2->PlayerGroup->CompletedTournaments->Tournament as $key => $value) {
        $conto=count($gioc2->PlayerGroup->CompletedTournaments->Tournament);
        if ($conto<2)
            $value=$gioc2->PlayerGroup->CompletedTournaments->Tournament;

        if(!array_key_exists($value->{'@id'},$ecco)){
            echo "<br>XXXXXXXXXXXXXXXXXXXXX ID: ".$value->{'@id'}." ".$value->{'@name'}."<br>";
        }
        //else
            //echo "\nPRESENTE: ".$value->{'@name'}."\n";
        if ($conto<2)
            break;
    }
    echo "SHARK :".$conto;
}