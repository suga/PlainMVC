<?php
namespace Application\Modulo\Controllers;

use Library\PlainMVC\Core\View\PlainHttpRequest;
use Library\PlainMVC\Core\View\PlainHttpResponse;

/**
 * My Controller example
 * To access this see details in every method below.
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 *
 */
class SiteIndexController {

	/**
     * My first action
     * Access using: http://yourserver/Plainmvc/web/index/modulo
     */
    public function indexAction(PlainHttpRequest $request) {
        echo 'Index';
        /* @var $parameter String */
        foreach ($request->getRequestParameters() as $index => $parameter) {
            var_dump($index . ' - ' . $parameter);
        }
        
        echo $request->getGetParameter('id');
    }
    
    /**
     * Other action
     * Access using: http://yourserver/Plainmvc/web/index/modulo/barfoobaz
     * @param $request
     */
    public function barfoobazAction(PlainHttpRequest $request) {
        var_dump(__METHOD__);
        echo $request->getControllerDirectory();
    }
}
