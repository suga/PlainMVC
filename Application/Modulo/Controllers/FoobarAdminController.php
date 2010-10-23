<?php
namespace Application\Modulo\Controllers;

use Library\PlainMVC\Core\View\PlainHttpRequest;
use Library\PlainMVC\Core\View\PlainHttpResponse;
use Library\PlainMVC\Util\Assertion;

/**
 * Shows templates only for /web/admin/ requests. With this you can create your secure admin cp :)
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 */
class FoobarAdminController {

    /**
     * To access this Action:
     * http://yourserver/Plainmvc/web/admin/index/modulo/foobar
     * @param PlainHttpRequest $request
     * @param PlainHttpResponse $response
     */
    public function foobarAction(PlainHttpRequest $request, PlainHttpResponse $response) {
        $response->getView()->render('admin/index.tpl');
    }
}
