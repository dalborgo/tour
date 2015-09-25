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
$dr=query("SELECT * FROM tt_tappa ORDER BY tappa DESC ");
$abbin = array();
$cont=0;
while (($h = mysql_fetch_assoc($dr))) {
    if($cont==0) {
        $cont++;
        continue;
    }
    $obj = new stdClass();

    $obj->descr=$h["descrizione"];
    $obj->tappa=$h["tappa"]."&deg;";
    $obj->parte=$h["partecipanti"];
    $obj->vinci=$h["vincitore"];
    $obj->soldil=$h["soldi_leader"];
    $obj->soldi=$h["soldi"];
    $obj->gialla=$h["leader"];
    $obj->verde=$h["punti"];
    $obj->rosso=$h["combat"];
    $obj->pois=$h["scalatore"];
    $obj->bianca=$h["giovane"];
    $obj->blu=$h["inter"];
    $obj->tipo=$h["tipo"];
    $obj->tipo=($obj->tipo=="pianeggiante")?"P":"M";
    $obj->diff=$h["diff"];
    $abbin[] = $obj;
}

$usc2 = new stdClass();
$usc2->data = $abbin;
echo json_encode($usc2);
