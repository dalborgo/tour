<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 15/09/2015
 * Time: 10:12
 */
include "librerie/date.php";
include "librerie/specific.php";

$inizio="Sep 13 2015";
//$interval=diffDate2($INIZIO);
//$dateW2 = new DateTime('06/31/2011');
//is_localhost();
//echo $_SERVER['SERVER_NAME'];
if (!isset($_SERVER['HTTP_HOST'])) {
    $actual_link = "";
} else {
    $actual_link = $_SERVER['HTTP_HOST'];
}




if($actual_link=="www.dalborgo.com")
    echo "go";
//$esc=getIntervallo($INIZIO);
$date = new DateTime();
$format=$date->format('Y-m-d');
$seco=date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $format) ) ));
$intervallo=diffDate2($inizio);
$out[0]=$intervallo;
$out[1]=strtotime($seco);
$out[2]=strtotime($format);
$tappa=$out[0];
//print_r($out);

