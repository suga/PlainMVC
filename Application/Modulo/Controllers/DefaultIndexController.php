<?php
namespace Application\Modulo\Controllers;

use Library\PlainMVC\Core\View;
use Library\PlainMVC\Core\View\PlainHttpRequest;
use Library\PlainMVC\Core\View\PlainHttpResponse;

/**
 * My Controller example
 * To access this see details in every method below.
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 *
 */
class DefaultIndexController {
    
    public function filter(PlainHttpRequest $request, PlainHttpResponse $response) {
        var_dump($request->getAction());
    }    
    
	/**
     * Default Page
     * Access using: http://yourserver/Plainmvc/web.
     */
    public function indexAction(PlainHttpRequest $request) {
        echo 'Default PlainMVC page.';
    }
}
