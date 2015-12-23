<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 11/09/2015
 * Time: 03:11
 */
header('Content-Type: application/json');
//$host = 'localhost';
//$user = 'root';
//$password = 'Montebaldo1';
//$db = 'rtr';
//
//$connection=mysql_connect($host,$user,$password);
//if (!$connection ) die('Cannot connect: ' . mysql_error());
//$connection=mysql_select_db($db);
//if (!$connection ) die('Cannot connect: ' . mysql_error());
//function query($s, $sub = false) {
//    if ($sub) {
//        $sq = mysql_query ( $s );
//        if (! $sq)
//            die ( 'Cannot connect: Query errata' );
//        return mysql_fetch_assoc ( $sq );
//    } else {
//        $sq = mysql_query ( $s );
//        if (! $sq)
//            die ( 'Cannot connect: Query errata' );
//
//        return $sq;
//    }
//}
include_once "librerie/sql.php";
$dr=query("SELECT
 *
FROM event
ORDER BY pos, nick");
$var=0;
$abbin = array();
$dr2=query("SELECT
 *
FROM live
where id=1");
$var=0;
$abbin = array();
$ft=mysql_fetch_assoc($dr2);
$sm=round($ft["totale"] / $ft["ingioco"]);
$smg=$sm;
$sm=number_format($sm,0,",",".");

$bb=explode("/",$ft["bui"]);
$bb=str_replace('.', '', $bb[0])*2;
while (($h = mysql_fetch_assoc($dr))) {
    //$tappa=$h["tp"];
    $obj = new stdClass();
    $nick = $h["nick"];
    $obj->posi=$h["pos"];
    $obj->strat=$h["strat"];
    if($h["pos"]==1200) {
        $obj->pos = "";
        $obj->bui = "";
        $obj->guadagno = "";
        $obj->simb = "";
        $obj->diff = "";
        $obj->nick=cre($h["nick"],$h["status"],$h["strat"]);
        $obj->elim = 2;
        $abbin[]=$obj;
        continue;
    }
    else
        $obj->pos=$h["pos"]."&deg;";
    if($var > $h["prec"])
        $obj->simb="<img src='media/images/GreenUpArrow.png' title=''>";
    else if ($var < $h["prec"])
        $obj->simb="<img src='media/images/RedDownArrow.png' title=''>";
    else
        $obj->simb="<img src='media/images/GreyNeutralArrow.png' title=''>";
    //if (substr($h["chips"], 0, 1) === '€') { $h["chips"]="&euro;".substr($h["chips"], 1); }

    if(strpos($h["chips"],"€") !== false ) {
        if ($h["chips"] == $h["prec"]) {
            $obj->simb = "<img src='media/images/GreyNeutralArrow.png' title=''>";
            $obj->diff = "";
            query("UPDATE event SET finito=1 where nick LIKE '$nick'");
        }
        else {
            $obj->simb = "<img src='media/images/RedDownArrow.png' title=''>";
            $obj->diff = "<span style='color:red;font-weight: bold'>-".$h["prec"]."</span>";
        }
        $h["chips"] = str_replace('€', '&euro;', $h["chips"]);
        $obj->guadagno=$h["chips"];
        $obj->bui = "";
        $obj->grezzo = 0;
        $obj->elim = 1;
    }
    else {
        $obj->guadagno="<b>".$h["chips"]."</b>";
        $h["chips"] = str_replace('.', '', $h["chips"]);
        $h["prec"] = str_replace('.', '', $h["prec"]);
        $obj->grezzo=$h["chips"];
        $obj->diff = $h["chips"] - $h["prec"];
        if($obj->diff > 0)
            $obj->simb="<img src='media/images/GreenUpArrow.png' title=''>";
        else if ($obj->diff < 0)
            $obj->simb="<img src='media/images/RedDownArrow.png' title=''>";
        else
            $obj->simb="<img src='media/images/GreyNeutralArrow.png' title=''>";
        $obj->diff=number_format($obj->diff,0,",",".");
        $obj->diff = ($obj->diff>0)? '<span style="color:green;font-weight: bold">+'.$obj->diff.'</span>'
            :'<span style="color:red;font-weight: bold">'.$obj->diff.'</span>';
        if ($h["chips"] - $h["prec"] == 0)
            $obj->diff="";
        $obj->bui = round($h["chips"] / $bb);
        $obj->elim = 0;
    }
    $obj->var='0';
    $obj->nick=cre($h["nick"],$h["status"],$h["strat"]);
    $abbin[]=$obj;
}

usort($abbin, "cmp");
$usc2 = new stdClass();
$usc2->sm = $sm;
$usc2->smg = $smg;
$usc2->time =  date('H:i', strtotime($ft["agg"]));
$usc2->livello = $ft["bui"];
$usc2->data = $abbin;
$usc2->quanti = "<span style='color:#3F7FE1'>".$ft["ingioco"]."</span> / ".$ft["totg"];

echo json_encode($usc2);


function cmp($a, $b)
{
    if ($a->elim == $b->elim) {
        if ($a->posi < $b->posi)
            return -1;
        else if ($a->posi > $b->posi)
            return 1;
        else
            return strcasecmp($a->strat, $b->strat);

    }
    return ($a->elim < $b->elim) ? -1 : 1;
}

function cre($nick,$status,$stra){
    return '<span title="'.$nick.'"><img style="vertical-align:middle" src="http://static.pokerstrategycdn.com/front/images/ranks/mini/' . $status  . '.png"/> <a href="http://it.pokerstrategy.com/user/mio2/profile/" style="text-decoration:none;color:black"><b>' . $stra .'</b></a></span>';
}
