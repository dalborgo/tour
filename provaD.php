<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 15/09/2015
 * Time: 10:12
 */
include "librerie/date.php";
include "librerie/specific.php";

$INIZIO="Sep 13 2015";
//$interval=diffDate2($INIZIO);
//$dateW2 = new DateTime('06/31/2011');


$esc=getIntervallo($INIZIO);
$tappa=$esc[0];
print_r($esc);