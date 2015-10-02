<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 11/09/2015
 * Time: 03:11
 */
include_once "librerie/sql.php";
include_once "librerie/date.php";
include_once "librerie/specific.php";


//$res = query("CREATE TEMPORARY TABLE IF NOT EXISTS table4 AS (SELECT tt_dati.`nick`, SUM(guadagno) as guadagno, COUNT(*) as tornei FROM `tt_dati` WHERE buyin <= 5.00 GROUP BY nick)");
$tappa=getTappa();
$dr=query("SELECT b.id, a.nome, categoria, b.nick, punti, status, squadra, maglia, pos, guad FROM `tt_pois` b JOIN tt_granpremi a ON a.id = b.id LEFT JOIN tt_player c ON b.nick = c.nick WHERE b.tappa='$tappa' order by categoria desc, a.id, punti desc");
//CONVERT(CAST(CONVERT(a.nome USING latin1) AS BINARY) as nome
//$f=addDate($INIZIO,$tappa);
$abbin = array();
$base=0;
$tra=0;
$cont=0;
$id_prec=0;
$trov=0;
$liso="";
$conq=0;
$titM="";
$ce=false;
$obj = new stdClass();
$obj->lista="<abbr title='";
while (($h = mysql_fetch_assoc($dr))) {
    $wer=$h["categoria"];
    $nok=$h["nome"];
    if ($trov==0) {
        $titM="(Cat. $wer) $nok\n";
        $id_prec=$h["id"];
        $trov=1;
        $conq++;
    }
    if($id_prec!=$h["id"]) {
        $conq++;
        $titM.="(Cat. $wer) $nok\n";
        $obj->lista.="$liso' class='senza'><img src='http://www.dalborgo.it/public/ss/bici.png'/></abbr>";
        $id_prec=$h["id"];
        if($ce)
            $abbin[] = $obj;
        $ce=false;
        $obj = new stdClass();
        $obj->lista="<abbr title='";
        $liso="";
        $cont=0;
    }
    $cont++;
    $obj->torn="&nbsp;&nbsp;".$h["nome"];//"<span style='margin-left: 5px'>merda</span>";
    if($h["categoria"]>4)
        $obj->cat="<img src='media/images/HC.jpg'>";
    else if ($h["categoria"]>3)
        $obj->cat="<img src='media/images/1C.jpg'>";
    else
        $obj->cat="<img src='media/images/2C.jpg'>";;
    $obj->part=$h["categoria"];
    if($cont==1 && $h["punti"]>0) {
        $posiz=$h["pos"];
        $guad=$h["guad"];
        $obj->punti1 = "<abbr title='$posiz&deg; (&euro;$guad)' class='nero'>".$h["punti"]."</abbr>";
        $obj->gioc1 = "<span style='margin-left: 5px'>".$h["nick"]."</span>";
        $obj->punti2="";
        $obj->punti3="";
        $obj->gioc2="";
        $obj->gioc3="";
        $ce=true;
    }
    if($cont==2 && $h["punti"]>0) {
        $posiz=$h["pos"];
        $guad=$h["guad"];
        $obj->punti2 = "<abbr title='$posiz&deg; (&euro;$guad)' class='nero'>".$h["punti"]."</abbr>";
        $obj->gioc2 = "<span style='margin-left: 5px'>".$h["nick"]."</span>";
    }
    if($cont==3 && $h["punti"]>0) {
        $posiz=$h["pos"];
        $guad=$h["guad"];
        $obj->punti3 = "<abbr title='$posiz&deg; (&euro;$guad)' class='nero'>".$h["punti"]."</abbr>";
        $obj->gioc3 = "<span style='margin-left: 5px'>".$h["nick"]."</span>";
    }
    if($h["punti"]==0)
        $liso.="X&nbsp; ".$h["nick"]."\n";
    else
        $liso.=$cont."&deg; ".$h["nick"]."\n";
    echo "";
    //$obj->maglia=$h["maglia"];
    //$obj->squadra=$h["squadra"];
    //$obj->status=$h["status"];
    //$obj->nick2 = $h["nick"];
    //$obj->nick='<span class="nowr"><img style="vertical-align:middle" src="http://www.dalborgo.it/public/ss/' . $h["status"]  . 'p.png"/> ' . $h["nick"] . '</span>';
}
if($ce) {
    $abbin[] = $obj;
    $obj->lista.="$liso' class='senza'><img src='http://www.dalborgo.it/public/ss/bici.png'/></abbr>";
}
$usc2 = new stdClass();
$usc2->data = $abbin;
$usc2->tappa = $tappa;
$usc2->tot = "<abbr title='$titM' class='nero'>".$conq."</abbr>";
$usc2->data2 = addDate($INIZIO,$tappa);
echo json_encode($usc2);
