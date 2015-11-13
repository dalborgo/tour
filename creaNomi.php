<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 15/09/2015
 * Time: 05:17
 */
include_once "librerie/sql.php";
include_once "librerie/specific.php";
include_once "librerie/fetch.php";
include_once "librerie/stringhe.php";
header('Content-Type: text/html; charset=utf-8');
$dr = query("SELECT * FROM tt_player");
$tappa = getTappa();
$comb = mysql_fetch_assoc(query("SELECT combat FROM tt_tappa WHERE tappa='$tappa'"));
$abbin = array();
$base = 0;
$tra = 0;
$cont = 0;
$arr = maglie();
//$s = "";
echo 'DELETE FROM "main"."replace_pattern_0_1" WHERE replacement LIKE \'[img]http://static.pokerstrategycdn.com/%\';';
echo 'DELETE FROM "main"."replace_pattern_0_1" WHERE replacement LIKE \'[img]http://www.dalborgo.com/tour/media/images/%\';';
echo 'DELETE FROM "main"."replace_pattern_0_1" WHERE replacement LIKE \'[img]http://www.dalborgo.com/shark/%\';';
$s="";
$contr=array();
$ecom="";
while (($h = mysql_fetch_assoc($dr))) {
    $m = "";
    if ($comb["combat"] == $h["nick"]) {
        $colore = "red";
        $ecom=$h["nick"];
    }
    else
        $colore = "black";
    if (array_key_exists($h["nick"], $arr))
        $m = $arr[$h["nick"]][0];
    if ($m == "gialla")
        $rui = '[img]http://www.dalborgo.com/tour/media/images/' . $m.'.png[/img]';
    else if ($m == "verde")
        $rui = '[img]http://www.dalborgo.com/tour/media/images/' . $m.'.png[/img]';
    else if ($m == "pois")
        $rui = '[img]http://www.dalborgo.com/tour/media/images/' . $m.'.png[/img]';
    else if ($m == "blu")
        $rui = '[img]http://www.dalborgo.com/tour/media/images/' . $m.'.png[/img]';
    else if ($m == "bianca")
        $rui = '[img]http://www.dalborgo.com/tour/media/images/' . $m.'.png[/img]';
    else {
        //$rui = '[img]http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $h["status"];
        if($h["squadra"]==null)
            $rui = '[img]http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $h["status"].'.png[/img]';
        else
            $rui = '[img]http://www.dalborgo.com/shark/'.strtolower($h["squadra"]).'.png[/img] ';
    }
    $contr[$h["nick"]]=$rui;
    $s = "REPLACE INTO";
    $s .= ' "main"."replace_pattern_0_1" ("url_pattern","input","replacement") VALUES ("http://it.pokerstrategy.com/","';
    $s .= "q" . $h["nick"];
    $s .= '","';
    $s .= $rui . '[url=http://it.pokerstrategy.com/user/' . $h["nick"] . '/profile/][color=' . $colore . '][b]' . $h["nick"] . '[/b][/color][/url]");';
    echo $s;
}
$dr2 = query("SELECT nome, network FROM tt_dati WHERE tappa > 1 AND nome IS NOT NULL GROUP BY nome");
echo "<br><br>";

while (($h = mysql_fetch_assoc($dr2))) {
    $m = "";
    if ("PartyPoker.it" == $h["network"])
        $net = "Party";
    if ("FullTilt" == $h["network"])
        $net = "[img]http://www.dalborgo.it/public/ss/full.png[/img] [b]FullTilt[/b]";
    if ("ActiveGames.it" == $h["network"])
        $net = "[img]http://www.dalborgo.it/public/ss/stan.png[/img] [b]Stanleybet.it[/b]";
    if ("iPoker.it" == $h["network"])
        $net = "[img]http://www.dalborgo.it/public/ss/tit.png[/img] [b]Titanbet.it[/b]";
    if ("PokerStars.it" == $h["network"])
        $net = "[img]http://www.dalborgo.it/public/ss/ps1.png[/img][b]PokerStars.it[/b]";
    if ("PokerStars" == $h["network"])
        $net = "[img]http://www.dalborgo.it/public/ss/ps1.png[/img][b]PokerStars[/b]";
    if ("PokerClub" == $h["network"])
        $net = "Lotto";
    if ("MicroGame" == $h["network"])
        $net = "[img]http://www.dalborgo.it/public/ss/all.png[/img] [b]Allinbet.it[/b]";
    $s = "REPLACE INTO";
    $s .= ' "main"."replace_pattern_0_1" ("url_pattern","input","replacement") VALUES ("http://it.pokerstrategy.com/","';
    $s .= "q" . $h["nome"];
    $s .= '","';
    $s .= '[b]'.$h["nome"] . '[/b] di ' . $net . '");';
    echo $s;
}
echo "<br><br>";
$res = query("SELECT * from tt_player where abil IS NULL");
while (($ra = mysql_fetch_assoc($res))) {
    $val=$ra["nick"];
    //echo "<b>$val</b><br>";
    $sup="";
    $base = ccall('http://www.sharkscope.com/api/dalborgo/playergroups/'.$val);
    $lis = $base->Response->PlayerGroupResponse->PlayerGroup->Players->Player;
    //$lis2[$val] = $base->Response->PlayerGroupResponse->PlayerGroup->Players->Player;
    if(is_object($lis)){
        if(!isset($lis->{'@optedout'})) {
            $sup=$lis->{'@name'};
            //ccall('http://www.sharkscope.com/api/dalborgo/playergroups/confra/members/'.$lis->{'@network'}.'/'.$lis->{'@name'});
        }
        if (array_key_exists($sup, $contr))
            continue;
        $colore = ($ecom==$val)?"red":"black";
        $s = "REPLACE INTO";
        $s .= ' "main"."replace_pattern_0_1" ("url_pattern","input","replacement") VALUES ("http://it.pokerstrategy.com/","';
        $s .= "q" . $sup;
        $s .= '","';
        $s .= $contr[$val] . '[url=http://it.pokerstrategy.com/user/' . $val . '/profile/][color=' . $colore . '][b]' . $val . '[/b][/color][/url]");';
        echo $s;
    }
    else {
        foreach ($lis as $o) {
            if(!isset($o->{'@optedout'})) {
                $sup=$o->{'@name'};
                //ccall('http://www.sharkscope.com/api/dalborgo/playergroups/confra/members/'.$o->{'@network'}.'/'.$o->{'@name'});
            }
            if (array_key_exists($sup, $contr))
                continue;
            $colore = ($ecom==$val)?"red":"black";
            $s = "REPLACE INTO";
            $s .= ' "main"."replace_pattern_0_1" ("url_pattern","input","replacement") VALUES ("http://it.pokerstrategy.com/","';
            $s .= "q" . $sup;
            $s .= '","';
            $s .= $contr[$val] . '[url=http://it.pokerstrategy.com/user/' . $val . '/profile/][color=' . $colore . '][b]' . $val . '[/b][/color][/url]");';
            echo $s;
        }
    }
}




