<?php
/**
 * My Controller example
 * To access this see details in every method below.
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 *
 */
class DefaultIndexController {

	/**
     * Default Page
     * Access using: http://yourserver/Plainmvc/web.
     */
    public function indexAction(PlainHttpRequest $request) {
        echo 'Default PlainMVC page.';
    }
}
