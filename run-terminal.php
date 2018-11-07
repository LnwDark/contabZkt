<?php
//use app\models\User;
include "zklibrary.php";
$ip = '192.168.86.24';
$port = 4370;
$zk = new ZKLibrary($ip, $port);
$con = $zk->connect();
if (!$con) {
    echo 'Connect';
    $dates = "2018-11-03";
    $date = date("Y-m-d");
    $att = $zk->getAttendance();
    $dataArray = [];
    foreach ($att as $key => $model) {
        $dataServer = substr($model[3], 0, 10);
        if ($dataServer == $date) {
            $dataArray[] = [
                'key' => $model[0],
                'user_id' => $model[1],
                'use_scan' => $model[2],
                'date_time' => $model[3]
            ];
        }
    }
    $url = '';
    $context = stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($dataArray),
            'timeout' => 60
        )
    ));
    $resp = file_get_contents($url, false, $context);
    print_r($resp);
    exit();
}
$zk->disableDevice();
