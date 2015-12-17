<?php
/**
 * Created by PhpStorm.
 * User: liujin834
 * Date: 12/17/15
 * Time: 12:01 PM
 */
include_once( __DIR__ ."/src/Zend/Loader/StandardAutoloader.php");

$loader = new \Zend\Loader\StandardAutoloader(array(
    'autoregister_zf' => false,
    'namespaces' => array(
        'VectorTile' => './src/VectorTile'
    ),
    'fallback_autoloader' => false,
));

// Register with spl_autoload:
$loader->register();