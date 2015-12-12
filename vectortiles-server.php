<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo $redis->get($_GET['zoom'] ."-". $_GET['x'] . "-" .$_GET['y']);
$redis->close();