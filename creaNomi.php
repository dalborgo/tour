<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 15/09/2015
 * Time: 05:17
 */
include_once "librerie/sql.php";
//INSERT INTO "main"."replace_pattern_0_1" ("url_pattern","input","replacement") VALUES ("http://it.pokerstrategy.com/","qwerr","sds")
$dr=query("SELECT * FROM tt_player");

//$f=addDate($INIZIO,$tappa);
$abbin = array();
$base=0;
$tra=0;
$cont=0;
$s='DELETE FROM "main"."replace_pattern_0_1" WHERE replacement LIKE \'[img]http://static.pokerstrategycdn.com/%\';';
echo "<br><br>".$s;
while (($h = mysql_fetch_assoc($dr))) {
    $s="INSERT INTO";
    $s.=' "main"."replace_pattern_0_1" ("url_pattern","input","replacement") VALUES ("http://it.pokerstrategy.com/","';
    $s.="q".$h["nick"];
    $s.='","';
    $s.='[img]http://static.pokerstrategycdn.com/front/images/ranks/mini/'.$h["status"].'.png[/img][url=http://it.pokerstrategy.com/user/'.$h["nick"].'/profile/][b]'.$h["nick"].'[/b][/url]");';
    echo $s;
}






