<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 13/05/2015
 * Time: 17:01
 */
/*
include_once "nomi.php";
if (!isset($lista)) {
    //$lista=$nonick;
    $lista="robbylli";
}
$lista=explode(",",$lista);

require_once "dbmarc.php";
*/
require_once "librerie/sql.php";
require_once "librerie/fetch.php";
$service_url = 'http://www.sharkscope.com/api/dalborgo/playergroups';
$decoded = ccall($service_url);
$ltot = $decoded->Response->PlayerGroupResponse->PlayerGroup;
foreach ($ltot as  $mio) {
    $value=$mio->{'@name'};
    $res[$value] = ccall('http://www.sharkscope.com/api/dalborgo/networks/PlayerGroup/players/'.$value
        .'/statistics/Ability,AvStake,AvGamesPerDay?filter=Class:SCHEDULED');
    echo $mio->{'@name'}."<br>";
}
//echo "miao";
foreach ($res as $k => $v) {
    $ls=$v->Response->PlayerResponse->PlayerView->PlayerGroup->Statistics->Statistic;
    if(count($ls)<2)
        continue;
    $out["nick"] = $k;
    $out["AvStake"] = $ls[0]->{'$'};
    $out["AvGamesPerDay"] = $ls[1]->{'$'};
    $out["Ability"] = $ls[2]->{'$'};
    repTV("tt_ranking", $out);
}

