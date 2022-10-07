<?php

try {
    $link = "https://services.brid.tv/services/mrss/latest/1/0/1/25/0.json";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    $videos = json_decode($res, true)["Video"];
} catch (Exception $ex) {
    echo $ex;
}
