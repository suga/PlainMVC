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
//class Autoload {
//    /**
//     * Autoloaded instance
//     * @var Autoload
//     */
//    private static $instance;
//    /**
//     * Autoload path
//     * @var String
//     */
//    private static $str_autoload;
//
//    
//    /**
//     * Private constructor
//     */
//    private function __construct() {
//
//    }
//
//    /**
//     * Get autoload instance
//     * @return Autoload
//     */
//    public static function getInstance() {
//        if (!self::$instance instanceof Autoload) {
//            self::$instance = new Autoload();
//        }
//        
//        return self::$instance;
//    }
//
//    /**
//     * Autoload
//     * @param ArrayAccess $aditionalDirectories
//     * @return void
//     */
//    public function load(ArrayAccess $aditionalDirectories = null) {
//        if (isset(self::$str_autoload)) {
//            return;
//        }
//        $arrobj_autoload = PlainConfig::getInstance()->getAutoloadPath();
//        
//        foreach ($arrobj_autoload as $path) {
//            self::$str_autoload .= $path . PATH_SEPARATOR;
//        }
//        
//        if ($aditionalDirectories instanceof ArrayAccess && $aditionalDirectories->count() > 0) {
//            foreach ($aditionalDirectories as $directory) {
//                self::$str_autoload .= $directory . PATH_SEPARATOR;
//            }
//        }
//        
//        set_include_path(self::$str_autoload . get_include_path());
//    }
//
//    /**
//     * Clear autoload string. Use this if you want to reload autoloading
//     * @return void
//     */
//    public function clear() {
//        self::$str_autoload = '';
//    }
//}
/**
 * Loading unknown classes
 * @param string $class
 */
function __autoload($class) {
    if (file_exists(\Library\PlainMVC\Core\PlainConfig::getInstance()->getRootDirectory() . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php')) {
        require_once \Library\PlainMVC\Core\PlainConfig::getInstance()->getRootDirectory() . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    }
//    $arr_includePath = explode(PATH_SEPARATOR, get_include_path());
//    $included = false;
//    
//    foreach ($arr_includePath as $directory) {
//        if (file_exists($directory . DIRECTORY_SEPARATOR . $class . '.php')) {
//            require_once ($directory . DIRECTORY_SEPARATOR . $class . '.php');
//            $included = true;
//            break;
//        }
//    }
//    
//    if (!$included) {
//        foreach ($arr_includePath as $directory) {
//            if (file_exists($directory . DIRECTORY_SEPARATOR . strtolower($class) . '.php')) {
//                require_once ($directory . DIRECTORY_SEPARATOR . strtolower($class) . '.php');
//                break;
//            }
//        }
//    }
}

\Twig_Autoloader::register();
spl_autoload_register(__NAMESPACE__ . '\__autoload');
//$autoload = Autoload::getInstance()->load();
//
