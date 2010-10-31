<?php
namespace Library;

use Library\PlainMVC\Core\View;
use Library\PlainMVC\Core;

use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration,
    Doctrine\Common\Cache\ArrayCache;

//if ($applicationMode == "development") {
    $cache = new \Doctrine\Common\Cache\ArrayCache;
//} else {
//    $cache = new \Doctrine\Common\Cache\ApcCache;
//}

$config = new Configuration;
$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver(Core\PlainConfig::getInstance()->getApplicationDirectory());
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir(Core\PlainConfig::getInstance()->getApplicationDirectory());
$config->setProxyNamespace(View\PlainHttpRequest::getInstance()->getNamespaceFor(Core\PlainConfig::getInstance()->getApplicationDirectory()));

//if ($applicationMode == "development") {
    $config->setAutoGenerateProxyClasses(true);
//} else {
//    $config->setAutoGenerateProxyClasses(false);
//}

$connectionOptions = array(
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'dbname'   => 'plainmvc',
    'user'     => 'hlegius',
    'password' => '987654'
);

class DoctrineConfig {
    private static $em;
    
    public function __construct($connectionOptions, $config) {
        if (!self::$em instanceof \Doctrine\ORM\EntityManager) {
            self::$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
        }
    }
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getInstance() {
        return self::$em;
    }
}

new DoctrineConfig($connectionOptions, $config);
