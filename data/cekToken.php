<?php
date_default_timezone_set('Etc/GMT');
include 'connection.php';
include 'ConfigClass.php';

$cfg = new Config($db);

$cekToken = $cfg->getConfig('accessToken');
$refreshToken = $cfg->getConfig('refreshToken');
//echo "exp date : ".strtotime($cekToken->cfgExpire)." today date : ".strtotime(date('Y-m-d H:i:s'))." <br/>";

if ($cekToken->cfgExpire > date('Y-m-d H:i:s')) {
    $token = $cekToken->cfgValue;
    //echo "token lama ".$token;
} else {
    //echo "token expired";

    $accessKey = $cfg->getConfig('accessKey');
    $accessSecret = $cfg->getConfig('accessSecret');

    $url = "https://dev.greatdayhr.com/api/auth/login";
    $data = [
        "accessKey" => $accessKey->cfgValue,
        "accessSecret" => $accessSecret->cfgValue
    ];

    //echo json_encode($data);
    $ch = curl_init($url);
    //attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    //set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    //return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //execute the POST request
    $result = curl_exec($ch);

    //close cURL resource
    curl_close($ch);

    $res = json_decode($result);
    //print_r($res);

    $updateAccessToken = $cfg->updateConfig($res->access_token,date('Y-m-d H:i:s', $res->created_at),date('Y-m-d H:i:s', $res->expired_at), 'accessToken');
    $updateAccessToken = $cfg->updateConfig($res->refresh_token,date('Y-m-d H:i:s', $res->created_at),date('Y-m-d H:i:s', $res->expired_at), 'refreshToken');

    $token = $res->access_token;
    //echo "token baru ".$token;

}
