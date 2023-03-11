<?php
$uniq_password = "GEO-INFOMETRICS-2021-8e78665435";
$hostname = "https://majayjay.com";

function c_req($data, $url, $enc_pass)
{

    // User data to send using HTTP POST method in curl

    // Data should be passed as json format
    $data_json = json_encode($data);
    // API URL to send data
    // curl initiate
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // SET Method as a POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Pass user data in POST command
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_exec($ch);

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $res = json_decode(curl_exec($ch), true);
    // Close curl
    curl_close($ch);

    if ($httpcode == 200) {
        return $res;
    } else {
        return $httpcode;
    }

}
function c_s_req($data, $url, $enc_pass)
{
    // section for validating all requirements

    // User data to send using HTTP POST method in curl

    // Data should be passed as json format
    $data_json = json_encode($data);
    // API URL to send data

    //   $url = 'http://localhost/test_gs/pages/mswd/scanner_receiverapi.php';

    // curl initiate
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // SET Method as a POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Pass user data in POST command
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_exec($ch);

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $res = curl_exec($ch);

    // Close curl
    curl_close($ch);

    if ($httpcode == 200) {
        return $res;
    } else {
        return $httpcode;
    }

}
