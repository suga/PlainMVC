<?php
namespace Library\PlainMVC\Core;
/**
 * Plain general Configuration
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Plainmvc\core
 * @version January, 16 2010
 */
class PlainConfig {
    /**
     * Autoloadable directory
     * @var ArrayObject
     */
    private $directoryTree;
    /**
     * PlainConfig instance
     * @var PlainConfig
     */
    private static $instance;
    /**
     * Application Root Directory
     * @var string
     */
    private static $foodir;
    /**
     * Application directory directory
     * @var string
     */
    private static $applicationDirectory = 'Application/';
    /**
     * Public Web directory
     * @var string
     */
    private static $publicDirectory;
    /**
     * Library (Plain) Directory
     * @var string
     */
    private static $libraryDirectory;
    /**
     * Modules directories
     * @var ArrayObject
     */
    private static $modulesDirectories;
    /**
     * Temporary files directory
     * @var string
     */
    private static $tempDirectory;
    /**
     * Templates directories pattern
     * @var string
     */
    private static $templateDirectory = 'Views';
    /**
     * Configuration directory
     * @var string
     */
    private static $configDirectory = 'Config';
    /**
     * Controller Directory
     * @var string
     */
    const CONTROLLERS_DIRECTORY = 'Controllers';
    
    
    /**
     * Constructor
     */
    private function __construct() {
        self::$modulesDirectories = new \ArrayObject();
        
        self::$applicationDirectory = str_replace('/', DIRECTORY_SEPARATOR, self::$applicationDirectory);
        self::$foodir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
        self::$applicationDirectory = realpath(self::$foodir . self::$applicationDirectory);
        self::$publicDirectory = realpath(self::$foodir . DIRECTORY_SEPARATOR . 'web');
        self::$libraryDirectory = realpath(self::$foodir . DIRECTORY_SEPARATOR . 'Library' . DIRECTORY_SEPARATOR);
        $this->directoryTree = new \ArrayObject();
    }
    
    /**
     * Retrieve a PlainConfig instance
     * @return PlainConfig
     */
    public static function getInstance() {
        if (!self::$instance instanceof PlainConfig) {
            self::$instance = new PlainConfig();
        }
        
        return self::$instance;
    }
    
    /**
     * Get directory tree for AutoLoad
     * @return ArrayObject
     */
    public function getAutoloadPath() {
        $this->scandir(self::$applicationDirectory);
        $this->scandir(self::$libraryDirectory);

        return $this->directoryTree;
    }
    
    /**
     * Retrieve Application directory
     * @return string
     */
    public function getApplicationDirectory() {
        return self::$applicationDirectory;
    }
    
    /**
     * Retrieve public directory path
     * @return string
     */
    public function getPublicDirectory() {
        return self::$publicDirectory;
    }
    
    /**
     * Retrieve root Library Directory
     * @return string
     */
    public function getLibraryDirectory() {
        return self::$libraryDirectory;
    }
    
    /**
     * Temporary directory
     * @return string
     */
    public function getTempDirectory() {
        /* @todo helio.costa -- mover para arquivo de configuração */
        self::$tempDirectory = (realpath(self::$foodir) . DIRECTORY_SEPARATOR . 'tmp');
        return self::$tempDirectory;
    }
    
    /**
     * Retrieve config directory
     * @return string
     */
    public function getConfigDirectory() {
        return realpath(self::$libraryDirectory . DIRECTORY_SEPARATOR . 'PlainMVC' . DIRECTORY_SEPARATOR . self::$configDirectory);
    }
    
    /**
     * Retrieve modules directories
     * @return ArrayObject
     */
    public function getModulesDirectories() {
        if (self::$modulesDirectories->count() == 0) {
            foreach (scandir(self::$applicationDirectory) as $directory) {
                if ($directory == '..' || $directory == '.') {
                    continue;
                }
                if (is_dir(self::$applicationDirectory . DIRECTORY_SEPARATOR . $directory)) {
                    self::$modulesDirectories->append(realpath(self::$applicationDirectory . DIRECTORY_SEPARATOR . $directory));
                }
            }
        }
        
        return self::$modulesDirectories;
    }
    
    /**
     * Retrieve templates directories pattern
     * @return string
     */
    public function getTemplatesDirPattern() {
        return self::$templateDirectory;
    }
    
    /**
     * Retrieve ROOT directory
     * @return string
     */
    public function getRootDirectory() {
        return self::$foodir;
    }

    /**
     * Scan subdirectories
     * @param string $directory
     * @return void
     */
    private function scandir($directory) {
        $directories = scandir($directory);
        
        foreach ($directories as $dir) {
            if ($dir == '.' || $dir == ".svn" || $dir == '..') {
                continue;
            }
            
            if (is_dir($directory . DIRECTORY_SEPARATOR . $dir)) {
                $this->directoryTree->append($directory . DIRECTORY_SEPARATOR . $dir . PATH_SEPARATOR);
                $this->scandir($directory . DIRECTORY_SEPARATOR . $dir);
            }
        }
    }
}
