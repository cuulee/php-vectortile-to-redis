<?php
class vectorTilesToRedis{

    private $path = "";
    private $tiles = [];

    public function __construct()
    {

    }


    private function initRedisConnection(){
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);

        return $redis;
    }

    public function setTilesPath($path){
        $this->path = $path;
    }

    public function import(){

        $redis = $this->initRedisConnection();

        $redis->flushAll();

        foreach($this->tiles as $key=>$file){
            $redis->set($key,file_get_contents($file));
            echo "insert: " .$key ."\r\n";
        }

        return true;
    }

    public function loadTiles(){

        $tiles = $this->getTilesList($this->path);

        foreach($tiles as $index=>$path){
            $tiles[$this->getTileKey($path)] = $path;
            unset($tiles[$index]);
        }

        $this->tiles = $tiles;

        return $tiles;
    }

    private function getTileKey($path){

        $key_path = str_replace($this->path,"",$path);
        $key_path = str_replace(".json","",$key_path);
        $key_path = trim(str_replace(DIRECTORY_SEPARATOR," ",$key_path));
        $key_path = str_replace(" ","-",$key_path);

        return $key_path;

    }

    private function getTilesList($path){

        $current_dir = opendir($path);

        $files = [];

        while(($file = readdir($current_dir)) !== false) {
            $sub_dir = $path . DIRECTORY_SEPARATOR . $file;
            if($file == '.' || $file == '..') {
                continue;
            } else if(is_dir($sub_dir)) {
                $files = array_merge($files,$this->getTilesList($sub_dir));
            } else {
                $files[] = $path . DIRECTORY_SEPARATOR . $file;
            }
        }

        return $files;

    }


}

$path = "/Users/liujin834/work/sookon/sookon-map/server/data/osm-dev";
$vt2rd = new vectorTilesToRedis();
$vt2rd->setTilesPath($path);
$vt2rd->loadTiles();
$vt2rd->import();
