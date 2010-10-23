<?php
namespace Library\PlainMVC\Core\View;

use Library\PlainMVC\Core\Types\String;
use Library\PlainMVC\Core\PlainConfig;

/**
 * HTTP Request Interceptor
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package library
 * @subpackage plainmvc
 * @subpackage core
 * @subpackage view
 * @version June, 13 2010
 */
final class PlainHttpRequest {

    /**
     * Instance of PlainHttpRequest
     * @var PlainHttpRequest
     */
    private static $instance;

    /**
     * Request from client
     * @var ArrayObject
     */
    private $request;

    /**
     * Get Request Parameters
     * @var ArrayObject
     */
    private $requestGet;

    /**
     * Post Request Parameters
     * @var ArrayObject
     */
    private $requestPost;

    /**
     * Module called
     * @var String
     */
    private $module;

    /**
     * Action requested
     * @var String
     */
    private $action;

    /**
     * Controller Class name
     * @var String
     */
    private $controller;

    /**
     * Controller file directory
     * @var String
     */
    private $controllerDirectory;

    /**
     * Directory Suffix
     * if need to use web/admin; web/foobar; web/foo/bar
     * The / caracter will be replaced by empty. i.e: web/foo/bar = SomeActionFooBarController.php
     * that is different of: web/foobar = SomeActionFoobarController.php (/!\ Caution: Windows and Mac aren't case sensitive)
     * In this cases directory suffix will scan for SomeAction{DirectorySuffix}Controller.php
     * @var string
     */
    private $directorySuffix = 'Index';

    /**
     * HttpRequest class
     * Construct HTTP Request
     * @param String $queryString
     */
    private function __construct(String $queryString) {
        $this->requestGet = new \ArrayObject();
        
        $str_decodeUrl = str_replace("request=", "", urldecode($queryString));
        $str_decodeUrl = rtrim($str_decodeUrl, ' /'); // yeap, with blank space
        $arr_moduleAction = explode('/', $str_decodeUrl);
        $int_totalModuleActions = count($arr_moduleAction);
                
        if (empty($str_decodeUrl)) {
            return;
        }
        
        if ($int_totalModuleActions <= 1) {
            $arr_moduleAction[] = 'index'; // if action not set, try to open index
        }
        
        if ($int_totalModuleActions > 2) {
            // Populating GET Request Parameters
            for ($i = 2; $i < $int_totalModuleActions; $i += 2) {
                $this->requestGet->offsetSet($arr_moduleAction[$i], isset($arr_moduleAction[$i + 1]) ? new String($arr_moduleAction[$i + 1]) : new String(""));
            }
        }
        
        $this->parsePostParameters();
        
        $arr_moduleAction = new \ArrayObject($arr_moduleAction);
        $this->module = new String($arr_moduleAction->offsetGet(0));
        
        if ($arr_moduleAction->offsetExists(1)) {
            $this->action = new String($arr_moduleAction->offsetGet(1));
        }
        
        if ($arr_moduleAction->count() < 2) {
            return;
        }
        
        $this->request = new \ArrayObject(array_merge($this->requestGet->getArrayCopy(), $this->requestPost->getArrayCopy()));
    }

    /**
     * Parse HTTP POST parameters
     * @return void
     * @access private
     */
    private function parsePostParameters() {
        settype($_POST, 'array');
        $this->requestPost = new \ArrayObject();
        
        foreach ($_POST as $index => $value) {
            if (is_array($value)) {
                $this->requestPost->offsetSet($index, $this->array2ArrayObject($value));
            } else {
                $this->requestPost->offsetSet($index, new String($value));
            }
        }
    }

    /**
     * Converts array into ArrayObject with indices for hashes
     * @param array $array
     * @return ArrayObject
     */
    private function array2ArrayObject($array) {
        $hash = new \ArrayObject();
        
        foreach ($array as $index => $value) {
            if (is_array($value)) {
                $hash->offsetSet($index, $this->array2ArrayObject($value));
            } else {
                $hash->offsetSet($index, new String($value));
            }
        }
        return $hash;
    }

    /**
     * Retrieve PlainHttpRequest instance
     * @return PlainHttpRequest
     */
    public static function getInstance() {
        if (!self::$instance instanceof PlainHttpRequest) {
            $querystring = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
            self::$instance = new PlainHttpRequest(new String($querystring));
        }
        return self::$instance;
    }

    /**
     * Unset PlainHttpRequest instance
     * @return void
     */
    public function kill() {
        self::$instance = null;
    }

    /**
     * Manipules dirname for Controllers name convention
     * @param string $dirname
     * @return void
     */
    private function generateDirname($dirname) {
        $dirname = str_replace(PlainConfig::getInstance()->getPublicDirectory(), '', $dirname);
        
        if (empty($dirname)) {
            return;
        }
        $arr_subdirectories = explode(DIRECTORY_SEPARATOR, $dirname);
        
        if (count($arr_subdirectories) > 1) {
            $str_dirpath = '';
            
            foreach ($arr_subdirectories as $directoryPathName) {
                $str_dirpath .= ucwords($directoryPathName);
            }
        } else {
            $str_dirpath = ucwords($dirname);
        }
        
        $this->directorySuffix = $str_dirpath;
    }

    /**
     * Dispatch controller
     * @return void
     */
    public function dispatch($dirname = '') {
        if (!self::getModule()) {
            $this->throwClassNotFoundException($dirname);
            return;
        }
        $str_directory = PlainHttpRequest::getInstance()->getModule() . DIRECTORY_SEPARATOR . PlainConfig::CONTROLLERS_DIRECTORY;
        $directories = explode(DIRECTORY_SEPARATOR, $str_directory);
        
        $str_directory = PlainConfig::getInstance()->getApplicationDirectory() . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, array_map("ucwords", $directories));

        if (!is_dir($str_directory)) {
            $this->throwClassNotFoundException($dirname);
            return;
        }
        $this->generateDirname($dirname);
        $class = null;
        
        foreach (scandir($str_directory) as $file) {
            $classFile = $str_directory . DIRECTORY_SEPARATOR . $file;
            
            if (strpos($classFile, $this->directorySuffix . 'Controller.php') === false) {
                continue;
            }
            $namespace = $this->getNamespaceFor($classFile);

            $className = substr($file, 0, -(strlen('Controller.php')));
            $className = $namespace . $className . 'Controller';
            
            try {
                $reflection = new \ReflectionClass($className);
                $method = PlainHttpRequest::getInstance()->getAction() . 'Action';
                
                if ($reflection->hasMethod($method)) {
                    $reflectionMethod = new \ReflectionMethod($className, $method);
                    
                    if ($reflectionMethod->isPublic() && !$reflectionMethod->isStatic()) {
                        $class = new $className();
                        break;
                    }
                }
            } catch (ReflectionException $rfe) {
            /** @internal its cannot be happen */
            /** if happen, check class name and file name. */
            }
        }
        
        if (is_null($class)) {
            $class = new PlainNotFoundActionController();
        } else {
            $this->controller = new String($className);
            $this->controllerDirectory = new String(realpath(dirname($classFile)));
        }
        
        $class->{PlainHttpRequest::getInstance()->getAction() . 'Action'}($this, PlainHttpResponse::getInstance());
    }
    
    /**
     * Retrieve namespace for file
     * @param string $file
     * @return string
     */
    public function getNamespaceFor($file) {
        $relativePath = str_replace($this->getPathBase(), '', $file);        
        $directories = explode(DIRECTORY_SEPARATOR, $relativePath);
        unset($directories[0], $directories[count($directories)]);
        
        return join("\\", array_map('ucwords', $directories)) . "\\";
    }

    /**
     * Throw not found class exception
     * @return void
     */
    private function throwClassNotFoundException($dirname) {
        $subdirectory = str_replace($this->getPathBase() . DIRECTORY_SEPARATOR . 'web', '', $dirname);
        $subdirectory = empty($subdirectory) ? 'Index' : $subdirectory;
        $subdirectories = explode(DIRECTORY_SEPARATOR, $subdirectory);
        
        $suffix = join("", array_map("ucwords", $subdirectories));
        $modulesPath = PlainConfig::getInstance()->getModulesDirectories();
        
        foreach ($modulesPath as $modulePath) {
            $moduleFiles = scandir($modulePath . DIRECTORY_SEPARATOR . 'Controllers');
            
            if (!in_array("Default{$suffix}Controller.php", $moduleFiles)) {
                continue;
            }
            
            $defaultCall = "Application\Modulo\Controllers\Default{$suffix}Controller";
            $reflectionModule = new \ReflectionClass($defaultCall);
            
            if ($reflectionModule->hasMethod('indexAction')) {
                $defaultClass = new $defaultCall();
                
                return $defaultClass->{'indexAction'}($this, PlainHttpResponse::getInstance());
            }
        }
        
        $actionName = (PlainHttpRequest::getInstance()->getAction()) ? PlainHttpRequest::getInstance()->getAction()->__toString() : 'notFound';
        $class = new PlainNotFoundActionController();
        $class->{$actionName . 'Action'}($this, PlainHttpResponse::getInstance());
        return;
    }

    /**
     * Retrieve current Module
     * @return String
     */
    public function getModule() {
        return $this->module;
    }

    /**
     * Current Action name
     * @return String
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * Retrieve Controller Class name
     * @return String
     */
    public function getControllerName() {
        return $this->controller;
    }

    /**
     * Retrieve Controller Directory
     * @return String
     */
    public function getControllerDirectory() {
        return $this->controllerDirectory;
    }

    /**
     * Retrieve Request parameters
     * @return ArrayObject
     */
    public function getRequestParameters() {
        return $this->request;
    }

    /**
     * Retrieve POST or GET parameter
     * @param string $name
     * @return mixed
     */
    public function getParameter($name) {
        if ($this->request->offsetExists($name)) {
            return $this->request->offsetGet($name);
        } else {
            return null;
        }
    }

    /**
     * Retrieve POST parameter
     * @param string $name
     * @return mixed
     */
    public function getPostParameter($name) {
        if ($this->requestPost->offsetExists($name)) {
            return $this->requestPost->offsetGet($name);
        } else {
            return null;
        }
    }

    /**
     * Retrieve GET parameter
     * @param string $name
     * @return mixed
     */
    public function getGetParameter($name) {
        if ($this->requestGet->offsetExists($name)) {
            return $this->requestGet->offsetGet($name);
        } else {
            return null;
        }
    }

    /**
     * Writes a value on session name
     * @param string $name
     * @param mixed $value
     */
    public function writeSession($name, $value) {
        $_SESSION[$name] = serialize($value);
    }

    /**
     * Retrieve session name
     * @param string $name
     * @return mixed
     */
    public function getSession($name) {
        return isset($_SESSION[$name]) ? unserialize($_SESSION[$name]) : false;
    }

    /**
     * Return and drop session name
     * @param string $name
     * @return mixed
     */
    public function getAndUnsetSession($name) {
        if (isset($_SESSION[$name])) {
            $value = unserialize($_SESSION[$name]);
            unset($_SESSION[$name]);
            
            return $value;
        }
        return false;
    }

    /**
     * Only drop Session
     * @param string $name
     * @return void
     */
    public function removeSession($name) {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }    

    /**
     * Returns application root path
     * @return string
     */
    public function getPathBase() {
        return realpath(dirname(__FILE__) . '/../../../../');
    }

    /**
     * Returns public application root path
     * @return string
     */
    public function getPublicPathBase() {
        return realpath(dirname(__FILE__) . '/../../../../web');
    }

    /**
     * Returns application's root URL address
     * @return string
     */
    public function getUrlBase() {
        return "http://" . $_SERVER['HTTP_HOST'] . '/';
    }

    /**
     * Retrieve current address
     * @return string
     */
    public function getCurrentUrl() {
        return $this->getUrlBase() . 'index/' . $this->getModule() . '/' . $this->getAction();
    }
}
