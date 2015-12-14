<?php
/**
 * Created by PhpStorm.
 * User: liujin834
 * Date: 12/14/15
 * Time: 2:59 PM
 */
interface databaseInterface{
    public function setConnection($param);
    public function saveTile($tile_key,$tile);
    public function flushData();
    public function getDatabase();
    public function closeConnection();
}