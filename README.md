### import vector tiles to redis

```php
include_once ('autoload.php');

use VectorTile\ToRedis;
use VectorTile\Db\Redis;

$path = "/Users/liujin834/work/sookon/sookon-map/server/data/osm-dev";
$vt2rd = new ToRedis;
$vt2rd->setTilesPath($path);

$redisDatabase = new Redis();
$redisDatabase->setConnection(['host'=>'127.0.0.1','port'=>'6379']);
$vt2rd->setDatabase($redisDatabase);

$vt2rd->setSaveMod(ToRedis::EXEC_MOD_FLUSH);
$vt2rd->loadTiles();
$vt2rd->import();
```

### fetch tiles
```php
$vt2rd = new ToRedis;
$vt2rd->setTilesPath($path);
var_dump($vt2rd->getTiles());
```

### set import mode

```php
$vt2rd = new ToRedis;
$vt2rd->setTilesPath($path);
$vt2rd->setRedisSaveMod(ToRedis::EXEC_MOD_FLUSH);
$vt2rd->loadTiles();
$vt2rd->import();
```
