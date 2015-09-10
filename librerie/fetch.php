<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 20/06/2015
 * Time: 01:44
 */

function ccall($eccolo){
    $curl = curl_init($eccolo);
    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = 'User-Agent: mozilla/5.0';
    $headers[] = 'Username: marco@dalborgo.it';
    $headers[] = 'Password: 4ecea959de2983563e2453a88debc873';
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    curl_close($curl);
    return json_decode($curl_response);
}
