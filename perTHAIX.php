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


while (($h = mysql_fetch_assoc($dr))) {
    if ($h["status"] != 'staff') {
        $colore = "#006CB0";
    }
    else
        $colore = "black";
        $rui = '[img]http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $h["status"];
//    $contr[$h["nick"]]=$rui;
    $s = "REPLACE INTO";
    $s .= ' "main"."replace_pattern_0_1" ("url_pattern","input","replacement") VALUES ("http://it.pokerstrategy.com/","';
    $s .= "q" . $h["nick"];
    $s .= '","';
    $s .= $rui . '.png[/img][url=http://it.pokerstrategy.com/user/' . $h["nick"] . '/profile/][color=' . $colore . '][b]' . $h["nick"] . '[/b][/color][/url]");';
    echo $s;
}