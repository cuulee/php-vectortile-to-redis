<?php
/**
 * Created by PhpStorm.
 * User: liujin834
 * Date: 12/14/15
 * Time: 3:02 PM
 */
class redisDatabase implements databaseInterface{

    /** @var  Redis */
    private $redis;

    /**
     * @param $param
     */
    public function setConnection($param)
    {
        $redis = new Redis();
        $this->redis = $redis->connect($param['host'],$param['port']);
    }

    /**
     * @param $tile_key
     * @param $tile
     */
    public function saveTile($tile_key,$tile)
    {
        $this->redis->set($tile_key,$tile);
    }

    public function flushData()
    {
        $this->redis->flushAll();
    }

    public function closeConnection()
    {
        $this->redis->close();
    }

    public function getDatabase()
    {
        return $this->redis;
    }

}