<?php
/**
 * Shows templates only for /web/admin/ requests. With this you can create your secure admin cp :)
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 */
class FoobarAdminController {

    /**
     * To access this Action:
     * http://yourserver/simplemvc/web/admin/index/modulo/foobar
     * @param SimpleHttpRequest $request
     * @param SimpleHttpResponse $response
     */
    public function foobarAction(SimpleHttpRequest $request, SimpleHttpResponse $response) {        
        $response->getView()->render('admin/index.tpl');
    }
}
