<?php
/**
 * PlainMVCRequest Tests
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 */
require_once dirname(__FILE__) . '/bootstrap.php';

class PlainMVCResponseTest extends PHPUnit_Framework_TestCase {

    /**
     * Test classes instances for Template controllers
     */
    public function testTemplateController() {
        $this->assertTrue(PlainHttpResponse::getInstance()->getView() instanceof PlainTemplate);
        $this->assertTrue(PlainHttpResponse::getInstance()->getView()->getTwigEnvironment() instanceof Twig_Environment);
    }
}

