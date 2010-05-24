<?php
/**
 * DefaultIndex Controller
 * To access this see details in every method below.
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 *
 */
class DefaultIndexController {

	/**
     * Default page when no one is setted.
     * Try this:
     *  -- http://yourserver/Plainmvc/web
     *  -- http://yourserver/Plainmvc/web/index
     *  -- http://yourserver/Plainmvc/web/index/
     *  -- http://yourserver/Plainmvc/web/index/modulo
     *  -- http://yourserver/Plainmvc/web/index/modulo/
     */
    public function indexAction(PlainHttpRequest $request, PlainHttpResponse $response) {
        echo 'Default Index Controller';
    }
}
