<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 17/11/2015
 * Time: 03:52
 */
include_once "librerie/sql.php";
include_once "librerie/specific.php";
include_once "librerie/fetch.php";
include_once "librerie/stringhe.php";
header('Content-Type: text; charset=utf-8');
$res = query("SELECT tt_nick.nick as nick, tt_player.squadra as squadra, player from tt_nick LEFT JOIN tt_player ON player = tt_player.nick WHERE squadra IS NOT NULL");
$s="<g>";
while (($ra = mysql_fetch_assoc($res))) {
    $n=$ra["nick"];
    $p=$ra["player"];
    $s.="<n";
    $s.=' id="'.$n.'">';
    //$s.=
    if($ra["squadra"]==null)
        $rui = '[img]http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $ra["status"].'.png[/img]';
    else
        $rui = '[img]http://www.dalborgo.com/shark/'.strtolower($ra["squadra"]).'.png[/img] ';
    $s.= $rui.'[url=http://it.pokerstrategy.com/user/' . $p . '/profile/][color=black][b]' . $p . '[/b][/color][/url]';
    $s.="</n>\n\n";
}
$s.="</g>";
echo $s;