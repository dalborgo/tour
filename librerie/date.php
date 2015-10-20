<?php

/**
 *
 * @param $d
 * @return string
 */
function dammiData($d){
    try {
        $datec = new DateTime($d);
        $datec->setTimezone(new DateTimeZone('Europe/Rome'));
        return $datec->format('Y-m-d');
    } catch (Exception $e) {return "";}
}
function dammiLocale(){
    try {
        $datec = new DateTime();
        $datec->setTimezone(new DateTimeZone('Europe/Rome'));
        return $datec->format('Y-m-d');
    } catch (Exception $e) {return "";}
}
function dammiOra($d){
    try {
        $datec = new DateTime($d);
        $datec->setTimezone(new DateTimeZone('Europe/Rome'));
        return $datec->format('H:i');
    } catch (Exception $e) {return "";}
}
function prog()
{
    $datec = new DateTime();
    $datec->setTimezone(new DateTimeZone('Europe/Rome'));
    $prog = $datec->format('z');
    return $prog;
}

function diffDate($inizio){
    $date = new DateTime();
    $format=$date->format('Y-m-d');
    $interval=date_diff(date_create($format), $inizio);
    return $interval->days;
}
function diffDate2($inizio){
    $str = $inizio;
    $str = strtotime(date("M d Y ")) - (strtotime($str));
    return floor($str/3600/24);
}


function addDate($inizio,$n){
    return date('d/m/Y', strtotime($inizio. " + $n days"));
}

