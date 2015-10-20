<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 15/09/2015
 * Time: 10:12
 */

include "librerie/sql.php";
include "librerie/fetch.php";
$fd=array();
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
       $fd['nick']=$sup;
       $fd['player']=$val;
       $fd['network']=$lis->{'@network'};
       repTV("tt_nick",$fd);
    }
    else {
        foreach ($lis as $o) {
            if(!isset($o->{'@optedout'})) {
                $sup=$o->{'@name'};
                //ccall('http://www.sharkscope.com/api/dalborgo/playergroups/confra/members/'.$o->{'@network'}.'/'.$o->{'@name'});
            }
            $fd['nick']=$sup;
            $fd['player']=$val;
            $fd['network']=$o->{'@network'};
            repTV("tt_nick",$fd);
        }
    }
}
echo "OK";