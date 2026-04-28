<?php

$url = $_SERVER['REQUEST_URI'];

if (strpos($url, '/users') === 0) {

    $target = "http://localhost:8001" . $url;

    $ch = curl_init($target);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    echo $response;
}