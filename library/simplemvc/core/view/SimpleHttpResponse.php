<?php
/**
 * HTTP Response class
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Simple\core\view
 * @version January, 27 2010
 */
final class SimpleHttpResponse {
    /**
     * SimpleHttpResponse Instance
     * @var SimpleHttpResponse
     */
    private static $instance;
    /**
     * Smarty Dependency injection
     * @var SimpleTemplate
     */
    private static $view;

    
    /**
     * Private HTTP Response constructor
     * @param Smarty $smarty
     * @return void
     */
    private function __construct() {
        self::$view = new SimpleTemplate();
    }
    
    /**
     * Retrieve SimpleHTTP Response
     * @return SimpleHttpResponse
     */
    public static function getInstance() {
        if (!self::$instance instanceof SimpleHttpRequest) {
            self::$instance = new SimpleHttpResponse();
        }
        return self::$instance;
    }
    
    /**
     * View Controller
     * @return SimpleTemplate
     */
    public function getView() {
        return self::$view;
    }
}
