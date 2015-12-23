<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 20/12/2015
 * Time: 04:32
 */
include_once "librerie/sql.php";
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
$in=$_POST["ingioco"];
$tg=$_POST["totg"];
$bui=$_POST["bui"];
$tt=$_POST["totale"]*1000;
$dr2=query("UPDATE live SET ingioco = $in, totale = $tt, totg = $tg , bui = '$bui'
where id=1");

