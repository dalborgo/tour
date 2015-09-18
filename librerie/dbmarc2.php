<?php
$host = 'sg112.servergrove.com';
$user = 'dalborgo';
$password = '90210';
$db = 'dalborgo_db';

$connection=mysql_connect($host,$user,$password);
if (!$connection ) die('Cannot connect: ' . mysql_error());
$connection=mysql_select_db($db);
if (!$connection ) die('Cannot connect: ' . mysql_error());

?>