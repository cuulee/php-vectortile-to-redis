### import vector tiles to redis

```php
include_once('vectorTilesToRedis.php');
include_once('redisDatabase.php');

$path = "/Users/liujin834/work/sookon/sookon-map/server/data/osm-dev";
$vt2rd = new vectorTilesToRedis();
$vt2rd->setTilesPath($path);

$redisDatabase = new redisDatabase(['host'=>'127.0.0.1','port'=>'6379']);
$vt2rd->setDatabase($redisDatabase);

$vt2rd->setSaveMod(vectorTilesToRedis::EXEC_MOD_FLUSH);
$vt2rd->loadTiles();
$vt2rd->import();
```

### fetch tiles
```php
$vt2rd = new vectorTilesToRedis();
$vt2rd->setTilesPath($path);
var_dump($vt2rd->getTiles());
```

### set import mode

```php
$vt2rd = new vectorTilesToRedis();
$vt2rd->setTilesPath($path);
$vt2rd->setRedisSaveMod(vectorTilesToRedis::EXEC_MOD_FLUSH);
$vt2rd->loadTiles();
$vt2rd->import();
```
