<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 09/12/2015
 * Time: 17:31
 */
$host = 'localhost';
$user = 'root';
$password = 'Montebaldo1';
$db = 'rtr';

$connection=mysql_connect($host,$user,$password);
if (!$connection ) die('Cannot connect: ' . mysql_error());
$connection=mysql_select_db($db);
if (!$connection ) die('Cannot connect: ' . mysql_error());

if (!isset($_GET['c']))
{
    exit("Manca un parametro necessario");
}else
    $c=$_GET['c'];

$id=mysql_fetch_assoc(query("SELECT
  nick
FROM ident
WHERE codice LIKE '$c'"));
if(!isset($id["nick"]))
        exit("Codice utente errato!");
echo "Ciao ".$id["nick"];



function query($s, $sub = false) {
    if ($sub) {
        $sq = mysql_query ( $s );
        if (! $sq)
            die ( 'Cannot connect: Query errata' );
        return mysql_fetch_assoc ( $sq );
    } else {
        $sq = mysql_query ( $s );
        if (! $sq)
            die ( 'Cannot connect: Query errata' );

        return $sq;
    }
}