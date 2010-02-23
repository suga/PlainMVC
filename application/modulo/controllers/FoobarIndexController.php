<?php
/**
 * Other "modulo" module Controller for /web/ directory
 * For /web/admin directory, see FoobarAdminController.php file
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 */
class FoobarIndexController {

    /**
     * Actions for FoobarIndex Controller
     * Access this method using: http://yourserver/simplemvc/web/index/modulo/bar
     * To give name GET parameter, access: http://yourserver/simplemvc/web/index/modulo/bar/name/Your Name Here
     * @param SimpleHttpRequest $request
     * @param SimpleHttpResponse $response
     */
    public function barAction(SimpleHttpRequest $request) {
        echo $request->getParameter("name"); // without template files
    }
    
    /**
     * Other FoobarIndexController Action method
     * Access this method using: http://yourserver/simplemvc/web/index/modulo/foobar
     * With GET parameters, access: http://yourserver/simplemvc/web/index/modulo/foobar/name/Your Name Here/othername/Other Name put here
     * @param SimpleHttpRequest $request
     * @param SimpleHttpResponse $response
     */
    public function foobarAction(SimpleHttpRequest $request, SimpleHttpResponse $response) {
//        $assert = new Assertion();
//        $assert->assert(true == false, __CLASS__ . ' @online ' . __LINE__);
//        $assert->assert("'bar' == 'baz'", __CLASS__ . ' @online ' . __LINE__);
        
        $response->getView()->assign('foo', $request->getParameter('name'));
        $response->getView()->assign('baz', $request->getGetParameter('othername'));
        $response->getView()->render('arquivo.tpl');
    }
}
