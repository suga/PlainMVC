<?php
namespace Library\PlainMVC\Core\View;
/**
 * HTTP Response class
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Plain\core\view
 * @version January, 27 2010
 */
final class PlainHttpResponse {
    /**
     * PlainHttpResponse Instance
     * @var PlainHttpResponse
     */
    private static $instance;
    /**
     * Smarty Dependency injection
     * @var PlainTemplate
     */
    private static $view;

    
    /**
     * Private HTTP Response constructor
     * @param Smarty $smarty
     * @return void
     */
    private function __construct() {
        self::$view = new PlainTemplate();
    }
    
    /**
     * Retrieve PlainHTTP Response
     * @return PlainHttpResponse
     */
    public static function getInstance() {
        if (!self::$instance instanceof PlainHttpResponse) {
            self::$instance = new PlainHttpResponse();
        }
        return self::$instance;
    }
    
    /**
     * View Controller
     * @return PlainTemplate
     */
    public function getView() {
        return self::$view;
    }
}
