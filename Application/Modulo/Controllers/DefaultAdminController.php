<?php
namespace Application\Modulo\Controllers;

use Library\PlainMVC\Core\View\PlainHttpRequest;
/**
 * My Controller example
 * To access this see details in every method below.
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 *
 */
class DefaultAdminController {

	/**
     * Default Page
     * Access using: http://yourserver/Plainmvc/web.
     */
    public function indexAction(PlainHttpRequest $request) {
        echo 'Default ADMIN PlainMVC page.';
    }
}
