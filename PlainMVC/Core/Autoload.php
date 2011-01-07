<?php
namespace Library\PlainMVC\Core;


require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'PlainConfig.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Internals' . DIRECTORY_SEPARATOR . 'Twig/Autoloader.php';

/**
 * Autoload classes
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Plainmvc\core
 * @version January, 16 2010
 */

/**
 * Loading unknown classes
 * @param string $class
 */
function __autoload($class) {
    if (file_exists(\Library\PlainMVC\Core\PlainConfig::getInstance()->getRootDirectory() . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php')) {
        require_once \Library\PlainMVC\Core\PlainConfig::getInstance()->getRootDirectory() . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    }
}

\Twig_Autoloader::register();
spl_autoload_register(__NAMESPACE__ . '\__autoload');
