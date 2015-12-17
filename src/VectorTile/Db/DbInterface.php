<?php
/**
 * Created by PhpStorm.
 * User: liujin834
 * Date: 12/14/15
 * Time: 2:59 PM
 *
 * 为了各种非结构化或者类似的键值对存储更加统一,可以通过实现此结构的方式实现
 *
 */
namespace VectorTile\Db;

interface DbInterface{
    /**
     * 打开一个数据库连接
     * @param $param
     * @return mixed
     */
    public function setConnection($param);

    /**
     * 保存瓦片,key->value 模式
     * @param $tile_key
     * @param $tile
     * @return mixed
     */
    public function saveTile($tile_key,$tile);

    /**
     * 清空之前的数据
     * @return mixed
     */
    public function flushData();

    /**
     * 获得当前数据库连接
     * @return mixed
     */
    public function getDatabase();

    /**
     * 关闭数据库连接
     * @return mixed
     */
    public function closeConnection();
}