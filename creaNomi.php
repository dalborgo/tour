<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 15/09/2015
 * Time: 05:17
 */
include_once "librerie/sql.php";
include_once "librerie/specific.php";
$dr=query("SELECT * FROM tt_player");
$tappa=getTappa();
$comb=mysql_fetch_assoc(query("SELECT combat FROM tt_tappa WHERE tappa='$tappa'"));
$abbin = array();
$base=0;
$tra=0;
$cont=0;
$arr=maglie();

$s='DELETE FROM "main"."replace_pattern_0_1" WHERE replacement LIKE \'[img]http://static.pokerstrategycdn.com/%\';';
$s.='DELETE FROM "main"."replace_pattern_0_1" WHERE replacement LIKE \'[img]http://www.dalborgo.com/tour/media/images/%\';';
echo "<br><br>".$s;
while (($h = mysql_fetch_assoc($dr))) {
    $m="";
    if($comb["combat"]==$h["nick"])
        $colore="red";
    else
        $colore="black";
    if(array_key_exists($h["nick"],$arr))
        $m=$arr[$h["nick"]][0];
    if($m=="gialla")
        $rui='[img]http://www.dalborgo.com/tour/media/images/'.$m;
    else if($m=="verde")
        $rui='[img]http://www.dalborgo.com/tour/media/images/'.$m;
    else if($m=="pois")
        $rui='[img]http://www.dalborgo.com/tour/media/images/'.$m;
    else if($m=="blu")
        $rui='[img]http://www.dalborgo.com/tour/media/images/'.$m;
    else if($m=="bianca")
        $rui='[img]http://www.dalborgo.com/tour/media/images/'.$m;
    else
        $rui='[img]http://static.pokerstrategycdn.com/front/images/ranks/mini/'.$h["status"];
    $s="INSERT INTO";
    $s.=' "main"."replace_pattern_0_1" ("url_pattern","input","replacement") VALUES ("http://it.pokerstrategy.com/","';
    $s.="q".$h["nick"];
    $s.='","';
    $s.=$rui.'.png[/img][url=http://it.pokerstrategy.com/user/'.$h["nick"].'/profile/][color='.$colore.'][b]'.$h["nick"].'[/b][/color][/url]");';
    echo $s;
}






