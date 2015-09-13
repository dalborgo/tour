<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 10/09/2015
 * Time: 17:45
 * @param $inizio
 * @return array
 */
$INIZIO="2015-09-11";
function getIntervallo($inizio){
    $date = new DateTime();
    $format=$date->format('Y-m-d');
    $seco=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $format) ) ));
    $dateW = new DateTime($format.'08:59:59');
    $dateW2 = new DateTime($seco.'09:00:00');
    $out = array();
    $interval=date_diff(date_create($format), $inizio);
    $out[0]=$interval->days;
    $out[1]=$dateW2->getTimestamp();
    $out[2]=$dateW->getTimestamp();
    return $out;
}