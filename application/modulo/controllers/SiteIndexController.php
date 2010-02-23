<?php
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
        echo $request->getControllerDirectory();
    }
}
