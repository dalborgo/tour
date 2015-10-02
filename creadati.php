<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 10/09/2015
 * Time: 15:27
 */
//require "simple_html_dom.php";
include "librerie/fetch.php";
include "librerie/sql.php";
include "librerie/specific.php";
include "librerie/date.php";
$esc=getIntervallo($INIZIO);
$tappa=$esc[0]; //(nick LIKE 'Parasar' OR nick LIKE 'stardust85') AND
$res = query("SELECT * from tt_player"); //nick LIKE 'Bosca95' AND
$lista="";
$status = array();
$squadra = array();
$under = array();
while (($ra = mysql_fetch_assoc($res))) {
    $val=$ra["nick"];
    $status[$val] = $ra["status"];
    $under[$val] = $ra["under"];
    $squadra[$val] = $ra["squadra"];
    $lista.="$val,";
}
$lista2=substr($lista,0,-1);
$lista2=explode(",",$lista);
$ore=$esc[1]."~".$esc[2];
echo '<br>'.$ore;
//$ore="1442163600~1442185200";
$res= array();
foreach ($lista2 as $key => $value) {
    $res[$value] = ccall('http://www.sharkscope.com/api/dalborgo/networks/PlayerGroup/players/'.$value.'/completedTournaments?order=Last,70&filter=Date:'.$ore.';Class:SCHEDULED');
}
$usc=array();
$err=array();
$atos=array();
$errC=array();
foreach ($res as $key2 => $value2) {

    //$gioc2=$value2->Response->PlayerResponse->PlayerView;
    if(!isset($value2->Response->PlayerResponse->PlayerView->PlayerGroup->CompletedTournaments->Tournament))
        continue;
    else
        $gioc2=$value2->Response->PlayerResponse->PlayerView;
    $usc['nick']=$key2;
    foreach ($gioc2->PlayerGroup->CompletedTournaments->Tournament as $key => $value) {
        $conto=count($gioc2->PlayerGroup->CompletedTournaments->Tournament);
        if ($conto<2)
            $value=$gioc2->PlayerGroup->CompletedTournaments->Tournament;
        if(isset($value->TournamentEntry->{'@prize'}))
            $pirce=($value->TournamentEntry->{'@prize'})?$value->TournamentEntry->{'@prize'}:'0';
        else
            $pirce='0';
        if(isset($value->{'@rebuyStake'}))
            $sireb=$value->{'@rebuyStake'};
        else
            $sireb='0';
        $buyd=(($value->{'@stake'}+$value->{'@rake'})>0)?($value->{'@stake'}+$value->{'@rake'}):'0';
        if($sireb!='0')
            $guad=$pirce-($value->{'@rake'}+floatval($sireb));
        else
            $guad=$pirce-($value->{'@stake'}+$value->{'@rake'});
        $datec="";$datec2="";$dateo="";
        $datec2 = dammiData("@".$value->{'@date'});
        $dateo = dammiOra("@".$value->{'@date'});
        $usc['guadagno']=($guad==0)?'0':$guad;
        $usc['rake']=$value->{'@rake'};
        $usc['data']=$datec2;
        $usc['ora']=$dateo;
        $usc['nome']=$value->{'@name'};
        $usc['id_torneo']=$value->{'@id'};
        $usc['posizione']=$value->TournamentEntry->{'@position'};
        $usc['network']=$value->{'@network'};
      //  $usc['squadra']=$squadra[$key2];
      //  $usc['under']=$under[$key2];
        $usc['entranti']=$value->{'@totalEntrants'};
        $usc['buyin']=$buyd;
        $usc['stake']=$value->{'@stake'};
        $usc['rebuyStake']=$sireb;
        $usc['tappa']=$tappa;
        repTV("tt_dati",$usc);
        if ($conto<2)
            break;
    }
}
echo "<br>OK - Tappa: ".$tappa;
