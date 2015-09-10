<?php
require_once "dbmarc.php";
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
function sVF($v, $f, $sub = false) {
    //echo "Select $v FROM $f";
    if ($sub) {
        $sq = mysql_query ( "Select $v FROM $f" );
        if (!$sq ) die("Select errata - tabella $f");
        return mysql_fetch_assoc ( $sq );
    }else {
       $vo = mysql_query ( "Select $v FROM $f" );
       if (!$vo ) die("'Select errata - tabella $f");
       return $vo;
    }
}
function sVFW($v, $f, $w, $sub = false) {
    //echo "Select $v FROM $f WHERE $w";
    if ($sub) {
        $sq = mysql_query ( "Select $v FROM $f WHERE $w" );
        if (!$sq ) die("Select errata - tabella $f");
        return mysql_fetch_assoc ( $sq );
    } else {
        $vo = mysql_query ( "Select $v FROM $f WHERE $w" );
        if (!$vo ) die("Select errata - tabella $f");
        return $vo;
    }
}
function uFVW($f, $v, $w) {
    echo "UPDATE $f SET $v WHERE $w";
    $sq=mysql_query ( "UPDATE $f SET $v WHERE $w" );
    if (!$sq ) die("Update errata - tabella $f");
}
function getvar($n, $d) {
    return (isset ( $_GET [$n] )) ? $_GET [$n] : $d;
}
function postvar($n, $d) {
    return (isset ( $_POST [$n] )) ? $_POST [$n] : $d;
}
function delFW($f, $w) {
    $sq=mysql_query ( "DELETE FROM $f WHERE $w" );
    if (!$sq ) die("Delete errata - tabella $f");
}

function truncate($t) {
    $sq=mysql_query ( "TRUNCATE $t" );
    if (!$sq ) die("truncate errata - tabella $f");
}

function repTV($t,$v) {
          $i=1;
          $sql= "REPLACE INTO $t (";
          $sql2= " VALUES (";
          while(list($key, $val)=each($v)){
            if ($i<count($v)){
                    $sql=$sql.$key.", ";
                if($val==null)
                     $sql2=$sql2."NULL, ";
                else{
                    $val=preg_replace("/\"/","'",$val);
                     $sql2=$sql2."\"".$val."\", ";
                }
            }
            else{
                $sql=$sql.$key.")";
                  if($val==null)
                     $sql2=$sql2."NULL)";
                else{
                    $val=preg_replace("/\"/","'",$val);          
                     $sql2=$sql2."\"".$val."\")";
                }
            }
            $i++;
          }
          $s=$sql.$sql2;
  // echo $s;
          $sq=mysql_query ($s);

          if (!$sq ) die("Replace errata - tabella $t");
}

