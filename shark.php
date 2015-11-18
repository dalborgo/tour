<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 19/10/2015
 * Time: 22:48
 */

include_once "librerie/sql.php";
include_once "librerie/specific.php";
include_once "librerie/fetch.php";
header('Content-Type: text/html; charset=utf-8');
$dr = query("SELECT * FROM tt_player");

$datec = new DateTime();
$datec->setTimezone(new DateTimeZone('Europe/Rome'));
$format = $datec->format('Y-m-d');
$seco = date('Y-m-d', (strtotime('-1 day', strtotime($format))));
$a = strtotime($seco . '07:00:00');
$b = strtotime($format . '06:59:59');
$ore = $a . "~" . $b;
while (($h = mysql_fetch_assoc($dr))) {
    $s="<a href='http://it.sharkscope.com/#Player-Statistics/Advanced-Search//networks/Player%20Group/players/".$h["nick"]."?filter=Class:SCHEDULED' target='_blank'>".$h["nick"]."</a>";
    echo $s."<br>";
    $s="<a href='http://it.sharkscope.com/#Player-Statistics/Advanced-Search//networks/Player%20Group/players/".$h["nick"]."?filter=Date:".$ore.";Class:SCHEDULED' target='_blank'>".$h["nick"]."(Tappa)</a>";
    echo $s."<br>";
    $s="<a href='http://it.sharkscope.com/#Player-Statistics/Advanced-Search//networks/Player%20Group/players/".$h["nick"]."?filter=Date:24H;Class:SCHEDULED' target='_blank'>".$h["nick"]."(24H)</a>";
    echo $s."<br><br>";
}