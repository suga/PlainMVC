<?php
/**
 * Doctrine custom configurations
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package Library
 */
namespace Library;

use Library\PlainMVC\Core\View, Library\PlainMVC\Core;
use Doctrine\ORM\EntityManager, Doctrine\ORM\Configuration, Doctrine\Common\Cache\ArrayCache;

$settings = Core\PlainConfig::getInstance()->getApplicationConfig();    
    
if ($settings['type'] != "production") {
    $cache = new \Doctrine\Common\Cache\ArrayCache;
} else {
    $cache = new \Doctrine\Common\Cache\ApcCache;
}

$config = new Configuration;
$config->setMetadataCacheImpl($cache);

## Doctrine Metadata configuration
// Annotation
$driverImpl = $config->newDefaultAnnotationDriver(Core\PlainConfig::getInstance()->getApplicationDirectory());
// Yaml files
//$driver = new YamlDriver(array(dirname(__FILE__) . '/../schema/'));
//$config->setMetadataDriverImpl($driver);
// XML files
//$driver = new \Doctrine\ORM\Mapping\Driver\XmlDriver(array('/path/to/xmlfiles'));
//$config->setMetadataDriverImpl($driver);


$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir(Core\PlainConfig::getInstance()->getApplicationDirectory());
$config->setProxyNamespace(View\PlainHttpRequest::getInstance()->getNamespaceFor(Core\PlainConfig::getInstance()->getApplicationDirectory()));

if ($settings['type'] != "production") {
    $config->setAutoGenerateProxyClasses(true);
} else {
    $config->setAutoGenerateProxyClasses(false);
}
$connectionOptions = array(
    'driver'   => $settings['database']['driver'],
    'host'     => $settings['database']['host'],
    'dbname'   => $settings['database']['dbname'],
    'user'     => $settings['database']['user'],
    'password' => $settings['database']['pass']
);

class DoctrineConfig {
    private static $em;
    
    public function __construct($connectionOptions, $config) {
        if (!self::$em instanceof \Doctrine\ORM\EntityManager) {
            self::$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
        }
    }
    
    /**
     * Retrieve EntityManager
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getInstance() {
        return self::$em;
    }
}

new DoctrineConfig($connectionOptions, $config);
