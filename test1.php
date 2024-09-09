<?php
date_default_timezone_set('Etc/GMT');
$dateFrom = date('Y-m-d',strtotime("-2 days"));
$dateTo = date('Y-m-d',strtotime("+1 days"));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://dev.greatdayhr.com/api/attendances/byPeriod?startDate='.$dateFrom.'&endDate='.$dateTo);
//curl_setopt($ch, CURLOPT_URL, 'https://dev.greatdayhr.com/api/attendances/byPeriod?startDate=2024-09-05&endDate=2024-09-07');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization:Bearer '.$token
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$dt = json_decode($result);
curl_close($ch);