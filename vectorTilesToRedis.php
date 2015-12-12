<?php
/**
 * Created by PhpStorm.
 * User: liujin834
 * Date: 12/12/15
 * Time: 10:44 PM
 */
class vectorTilesToRedis{

    private $path = "";
    private $tiles = [];

    const EXEC_MOD_APPEND = 1;
    const EXEC_MOD_FLUSH = 2;

    private $exec_mod;

    public function __construct()
    {
        $this->exec_mod = self::EXEC_MOD_FLUSH;
    }


    private function initRedisConnection(){
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);

        return $redis;
    }

    public function setRedisSaveMod($mod){
        if($mod == self::EXEC_MOD_APPEND || $mod == self::EXEC_MOD_FLUSH)
            $this->exec_mod = $mod;
    }

    public function setTilesPath($path){
        $this->path = $path;
    }

    public function getTiles(){
        return $this->tiles;
    }

    public function import(){

        $redis = $this->initRedisConnection();

        if($this->exec_mod == self::EXEC_MOD_FLUSH)
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