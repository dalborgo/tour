<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 20/06/2015
 * Time: 02:32
 */

function togliUltimo($s){
    return substr($s,0,-1);
}

function startWith($s,$v){
    return substr($s,0,strlen($v))===$v;
}