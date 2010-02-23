<?php
/**
 * Simple general Configuration
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\simplemvc\core
 * @version January, 16 2010
 */
class SimpleConfig {
    /**
     * Autoloadable directory
     * @var ArrayObject
     */
    private $directoryTree;
    /**
     * SimpleConfig instance
     * @var SimpleConfig
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
    private static $applicationDirectory = 'application/';
    /**
     * Public Web directory
     * @var string
     */
    private static $publicDirectory;
    /**
     * Library (Simple) Directory
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
    private static $templateDirectory = 'views';
    /**
     * Configuration directory
     * @var string
     */
    private static $configDirectory = 'config';
    /**
     * Controller Directory
     * @var string
     */
    const CONTROLLERS_DIRECTORY = 'controllers';
    
    
    /**
     * Constructor
     */
    private function __construct() {
        self::$modulesDirectories = new ArrayObject();
        
        self::$applicationDirectory = str_replace('/', DIRECTORY_SEPARATOR, self::$applicationDirectory);
        self::$foodir = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
        self::$applicationDirectory = realpath(self::$foodir . self::$applicationDirectory);
        self::$publicDirectory = realpath(self::$foodir . DIRECTORY_SEPARATOR . 'web');
        self::$libraryDirectory = realpath(self::$foodir . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR);
        $this->directoryTree = new ArrayObject();
    }
    
    /**
     * Retrieve a SimpleConfig instance
     * @return SimpleConfig
     */
    public static function getInstance() {
        if (!self::$instance instanceof SimpleConfig) {
            self::$instance = new SimpleConfig();
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
        return realpath(self::$libraryDirectory . DIRECTORY_SEPARATOR . 'simplemvc' . DIRECTORY_SEPARATOR . self::$configDirectory);
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
