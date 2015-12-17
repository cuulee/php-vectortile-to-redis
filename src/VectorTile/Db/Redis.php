<?php
/**
 * Created by PhpStorm.
 * User: liujin834
 * Date: 12/14/15
 * Time: 3:02 PM
 */
namespace VectorTile\Db;

class Redis implements DbInterface{

    /** @var  \Redis */
    private $redis;

    private $param;

    public function __construct($param = ""){
        $this->param = $param;
    }

    /**
     * @param $param
     * @return null
     */
    public function setConnection($param)
    {
        if(empty($param))
            $param = $this->param;

        if(empty($param))
            exit("cannot connect to a empty database");

        $redis = new \Redis();
        $redis->connect($param['host'],$param['port']);
        $this->redis = $redis;
    }

    /**
     * @param $tile_key
     * @param $tile
     * @return null
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