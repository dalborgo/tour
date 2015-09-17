<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 10/09/2015
 * Time: 17:45
 * @param $inizio
 * @return array
 */
$INIZIO="Sep 13 2015";
function getIntervallo($inizio){
    $date = new DateTime();
    $format=$date->format('Y-m-d');
    $seco=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $format) ) ));
    $intervallo=diffDate2($inizio);
    $out[0]=$intervallo;
    if (!isset($_SERVER['HTTP_HOST'])) {
        $actual_link = "";
    } else {
        $actual_link = $_SERVER['HTTP_HOST'];
    }
    if($actual_link=="www.dalborgo.com") {
        $out[1] = strtotime($seco . '07:00:00');
        $out[2] = strtotime($format . '06:59:59');
        echo "dalborgo.com";
    }else{
        $out[1] = strtotime($seco . '09:00:00');
        $out[2] = strtotime($format . '08:59:59');
        echo "localhost";
    }
    return $out;
}
function getTappa(){
    $tu = mysql_fetch_assoc(query("SELECT max(tappa) AS tp FROM `tt_tappa`"));
    $tappa = $tu["tp"] - 1;
    return $tappa;
}