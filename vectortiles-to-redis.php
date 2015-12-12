<?php
include_once('vectorTilesToRedis.php');

$path = "/Users/liujin834/work/sookon/sookon-map/server/data/osm-dev";
$vt2rd = new vectorTilesToRedis();
$vt2rd->setTilesPath($path);
$vt2rd->loadTiles();
$vt2rd->import();