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



//$tappa=getTappa();
$dr=query("SELECT * FROM tt_tappa join tt_player on vincitore = nick ORDER BY tappa DESC ");
$abbin = array();
$cont=0;
while (($h = mysql_fetch_assoc($dr))) {
    if($cont==0) {
        $cont++;
        continue;
    }
    $piu=$h["tappa"];
    $ecco=date('d/m/Y', strtotime($INIZIO. " + $piu days"));
    $obj = new stdClass();
    $obj->descr=$h["descrizione"];
    $obj->tappa="<abbr title='$ecco' class='nero'>".$h["tappa"]."&deg;</abbr>";
    $obj->parte=$h["partecipanti"];
    $obj->vinci='<img style="vertical-align:middle" src="../shark/'.strtolower($h["squadra"]).'.png"></img> '.$h["vincitore"];
    $obj->soldil=$h["soldi_leader"];
    $obj->soldi=$h["soldi"];
    $obj->gialla=$h["leader"];
    $obj->verde=$h["punti"];
    $obj->rosso=$h["combat"];
    $obj->pois=$h["scalatore"];
    $obj->bianca=$h["giovane"];
    $obj->blu=$h["inter"];
    $obj->squadra=$h["squadra"];
    $obj->tipo=$h["tipo"];
    $obj->tipo=($obj->tipo=="pianeggiante")?"P":"M";
    $obj->diff=$h["diff"];
    $abbin[] = $obj;
}

$usc2 = new stdClass();
$usc2->data = $abbin;
echo json_encode($usc2);
