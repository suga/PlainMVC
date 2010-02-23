<?php
/**
 * HTTP Request Interceptor
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Plainmvc\core\view
 * @version January, 17 2010
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
     * @var unknown_type
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
        $this->request      = new ArrayObject();
        $this->requestGet   = new ArrayObject();
        $this->requestPost  = new ArrayObject();
        
        $str_decodeUrl = str_replace("request=", "", urldecode($queryString));
        $str_decodeUrl = rtrim($str_decodeUrl, ' /'); // yeap, with blank space
        $arr_moduleAction = explode('/', $str_decodeUrl);
        $int_totalModuleActions = count($arr_moduleAction);
        
        if (empty($str_decodeUrl)) {
            /* @todo helio.costa -- criar engine para módulo default */
            return ;
        }

        if ($int_totalModuleActions <= 1) {
            $arr_moduleAction[] = 'index'; // if action not set, try to open index
        }

        if ($int_totalModuleActions > 2) {
            // Populating GET Request Parameters
            for ($i=0; $i<count($arr_moduleAction) / 2; $i+=2) {
                $this->requestGet->offsetSet($arr_moduleAction[$i+2], new String($arr_moduleAction[$i+3]));
            }
        }
        if (is_array($_POST)) {
            // Population POST parameters
            $arr_moduleAction = array_merge($arr_moduleAction, $_POST);
            
             foreach ($_POST as $index => $value) {
                $this->requestPost->offsetSet($index, new String($value));
            }
        }
        
        $arr_moduleAction = new ArrayObject($arr_moduleAction);
        $this->module = new String($arr_moduleAction->offsetGet(0));
        
        if ($arr_moduleAction->offsetExists(1)) {
            $this->action = new String($arr_moduleAction->offsetGet(1));
        }
        
        if (!$arr_moduleAction->offsetExists(2)) {
            return ;
        }
        $arr_moduleAction->offsetUnset(0);
        $arr_moduleAction->offsetUnset(1);   

        for ($i=0; $i<=$arr_moduleAction->count() / 2; $i+=2) {
            if (!$arr_moduleAction->offsetExists($i+2)) {
                break;
            }
            if (is_bool($arr_moduleAction->offsetGet($i+2)) || $arr_moduleAction->offsetGet($i+2) == "") {
                continue;
            }
            $parameter = ($arr_moduleAction->offsetExists($i+3)) ? $arr_moduleAction->offsetGet($i+3) : null;
            $this->request->offsetSet($arr_moduleAction->offsetGet($i+2), new String($parameter));
        }
    }
    
    /**
     * Retrieve PlainHttpRequest instance
     * @return PlainHttpRequest
     */
    public static function getInstance() {
        if (!self::$instance instanceof PlainHttpRequest) {
            self::$instance = new PlainHttpRequest(new String($_SERVER['QUERY_STRING']));
        }
        return self::$instance;
    }
    
    /**
     * Manipules dirname for Controllers name convention
     * @param string $dirname
     * @return void
     */
    private function generateDirname($dirname) {
        $dirname = str_replace(PlainConfig::getInstance()->getPublicDirectory(), '', $dirname);
        
        if (empty($dirname)) {
            return ;
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
            $this->throwClassNotFoundException();
            return ;
        }
        $str_directory = PlainConfig::getInstance()->getApplicationDirectory() . DIRECTORY_SEPARATOR . PlainHttpRequest::getInstance()->getModule() . DIRECTORY_SEPARATOR . PlainConfig::CONTROLLERS_DIRECTORY;
        
        if (!is_dir($str_directory)) {
            $this->throwClassNotFoundException();
            return ;
        }
        $this->generateDirname($dirname);
        $class = null;
        
        /** @todo helio.costa -- ele poderia aprender os caminhos para evitar foreach futuro em tempo de execução :) */
        foreach (scandir($str_directory) as $file) {
            $classFile = $str_directory . DIRECTORY_SEPARATOR . $file;
            
            if (strpos($classFile, $this->directorySuffix . 'Controller.php') === false) {
                continue;
            }
            $className = substr($file, 0, -(strlen('Controller.php')));
            $className = $className . 'Controller';
            try {
                $reflection = new ReflectionClass($className);
                $method = PlainHttpRequest::getInstance()->getAction() . 'Action';

                if ($reflection->hasMethod($method)) {
                    $reflectionMethod = new ReflectionMethod($className, $method);
                    
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
     * Throw not found class exception
     * @return void
     */
    private function throwClassNotFoundException() {
        $actionName = (PlainHttpRequest::getInstance()->getAction()) ? PlainHttpRequest::getInstance()->getAction()->__toString() : 'notFound';
        $class = new PlainNotFoundActionController();
        $class->{$actionName . 'Action'}($this, PlainHttpResponse::getInstance());
        return ;
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
}
