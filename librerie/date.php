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