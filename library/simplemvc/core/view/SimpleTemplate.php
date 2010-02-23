<?php
/**
 * Facade for Twig_Environment
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @version Feb, 22 2010
 * @package \library\simplemvc\core\view
 */
final class SimpleTemplate {
    /**
     * Twig_Environment
     * @var Twig_Environment
     */
    private static $template;
    /**
     * ArrayAccess
     * @var ArrayAccess
     */
    private $variables;
    
    
    /**
     * Initialize facade
     */
    public function __construct() {
        $templatesDirs = array();
        
        // Looking for Templates directories        
        foreach (SimpleConfig::getInstance()->getModulesDirectories() as $moduleDirectory) {
            foreach (scandir($moduleDirectory) as $file) {
                $currentFile = new String($moduleDirectory . DIRECTORY_SEPARATOR . $file);
                $file = new String($file);
                
                if (!is_dir($currentFile)) {
                    continue;
                }
                
                if ($file->equals(SimpleConfig::getInstance()->getTemplatesDirPattern())) {
                    $templatesDirs[] = realpath($currentFile);
                }
            }
        }
        $twigLoader = new Twig_Loader_Filesystem($templatesDirs);
        self::$template = new Twig_Environment($twigLoader, array('cache' => (SimpleConfig::getInstance()->getTempDirectory() . 
                                                                                    DIRECTORY_SEPARATOR . 'tpl_cache')));    
        $this->variables = new ArrayObject();
    }

    /**
     * Assign new value for template
     * @param string $index
     * @param mixed $value
     */
    public function assign($index, $value) {
        $this->variables->offsetSet($index, $value);
    }
    
    /**
     * Show me Template
     * @param string $templateFileName
     */
    public function render($templateFileName) {
        $template = self::$template->loadTemplate($templateFileName);
        echo $template->render($this->variables->getArrayCopy());
    }
    
    /**
     * Returns Twig_Environment
     * @return Twig_Environment
     */
    public function getTwigEnvironment() {
        return self::$template;
    }
}
