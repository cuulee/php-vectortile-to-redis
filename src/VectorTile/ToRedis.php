<?php
/**
 * Created by PhpStorm.
 * User: liujin834
 * Date: 12/12/15
 * Time: 10:44 PM
 */
namespace VectorTile;

use VectorTile\Db\DbInterface;

class ToRedis{

    private $path = "";
    private $tiles = [];

    const EXEC_MOD_APPEND = 1;
    const EXEC_MOD_FLUSH = 2;

    private $exec_mod;

    /** @var  DbInterface */
    private $database;

    public function __construct()
    {
        $this->exec_mod = self::EXEC_MOD_FLUSH;
    }

    public function setDatabase(DbInterface $database){

        if($database instanceof DbInterface)
            $this->database = $database;
        else
            throw \Exception('database must is a instance of databaseInterface');
    }

    public function setSaveMod($mod){
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

        if($this->exec_mod == self::EXEC_MOD_FLUSH){
            try{
                $this->database->flushData();
            }catch(\Exception $e){
                echo $e->getMessage();
                echo "\r\n";
            }
        }

        foreach($this->tiles as $key=>$file){
            $this->database->saveTile($key,file_get_contents($file));
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