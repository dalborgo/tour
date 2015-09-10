<?php
$host = 'localhost';
$user = 'root';
$password = 'Montebaldo1';
$db = 'dalborgo_db';

$connection=mysql_connect($host,$user,$password);
if (!$connection ) die('Cannot connect: ' . mysql_error());
 $connection=mysql_select_db($db);
if (!$connection ) die('Cannot connect: ' . mysql_error());

?>