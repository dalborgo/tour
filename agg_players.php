<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 13/05/2015
 * Time: 15:29
 */

include "librerie/sql.php";
include "librerie/fetch.php";
require_once "librerie/simple_html_dom.php";

$service_url = 'http://www.sharkscope.com/api/dalborgo/playergroups';
$decoded = ccall($service_url);
$ltot = $decoded->Response->PlayerGroupResponse->PlayerGroup;
$sq = query("SELECT nick, squadra, abil, under, status from tt_player");
$sa = array();
$saa = array();
$sta = array();
$sta2 = array();
while (($ra = mysql_fetch_assoc($sq))) {
    $fg=$ra["nick"];
    $sa[$fg]=$ra["squadra"];
    $sta[$fg]=$ra["status"];
    $saa[$fg]=$ra["abil"];
    $sta2[$fg]=$ra["under"];
}
foreach ($ltot as  $mio) {

    $out["nick"]=$mio->{'@name'};
    if($out["nick"]=="confra")
        continue;
    $ns=$mio->{'@name'};
    $out["ultima"]=$mio->{'@lastActivity'};
    if (isset($_GET['f'])) {
        $rrr=getProf($out["nick"]);
        if($rrr!=$sta[$out["nick"]])
            echo "XXXXXXXXXXXXXXXX ".$out["nick"]." ".$sta[$out["nick"]]." -> ".$rrr."<br>";
        $out["status"] = $rrr;
    }
    else
        $out["status"]=($sta[$out["nick"]])?$sta[$out["nick"]]:getProf($out["nick"]);
    $nuovst=$out["status"];
    echo $mio->{'@name'}." -> $nuovst <br>";
    //echo $out["nick"]."<br>";
    $out["squadra"] = $sa[$out["nick"]];
    $out["abil"] = $saa[$out["nick"]];
    $out["under"] = $sta2[$out["nick"]];
    //$datec = new DateTime($out["ultima"]);
    //$datec->setTimezone(new DateTimeZone('Europe/Rome'));
    $out["ultima"] = date('Y-m-d',$out["ultima"]);
    repTV("tt_player", $out);
}
include_once "creaNomi.php";

function getProf($nome){
    if ($nome == "DONSABY")
        $nome="molokai";
    if ($nome == "midman79")
        $nome="midman";
    if ($nome == "Napo")
        $nome="NapoMDR";
    $link="http://it.pokerstrategy.com/user/".$nome."/profile/";
    $html = file_get_html($link);
    foreach($html->find('div[class=userAvatarContainer]') as $element) {
        $str=$element->children(0)->src;
        $arr = explode (':',$str);
        $ss = $arr[3];
        $arr = explode (',',$ss);
        $im=substr($arr[0],0,-4);
    }
    return $im;
}