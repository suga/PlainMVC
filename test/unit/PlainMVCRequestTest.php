<?php
/**
 * PlainMVCRequest Tests
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 */
require_once dirname(__FILE__) . '/bootstrap.php';

class PlainMVCRequestTest extends PHPUnit_Framework_TestCase {
    protected $webdir;
    
    /**
     * Test constructor
     */
    public function __construct() {
        $this->webdir = dirname(__FILE__) . '/../../web/';
    }
    
    public function tearDown() {
        PlainHttpRequest::getInstance()->kill();
    }
    
    /**
     * Test Get Parameters
     */
    public function testGetParameters() {
        $_SERVER['QUERY_STRING'] = 'request=/index/foobar/123456';

        PlainHttpRequest::getInstance()->dispatch($this->webdir);
        $this->assertEquals('123456', PlainHttpRequest::getInstance()->getGetParameter('foobar')->__toString());
        
        $_SERVER['QUERY_STRING'] = 'request=modulo/bar/foo/123456/baz/Hélio Costa/othername/John Doe';
        PlainHttpRequest::getInstance()->kill();
        PlainHttpRequest::getInstance()->dispatch($this->webdir);
        $this->assertEquals(3, PlainHttpRequest::getInstance()->getRequestParameters()->count());
        
        $_SERVER['QUERY_STRING'] = 'request=modulo/bar/foo/123456/baz/John Doe/baz/Hélio Costa';
        PlainHttpRequest::getInstance()->kill();
        PlainHttpRequest::getInstance()->dispatch($this->webdir);
        $this->assertEquals(2, PlainHttpRequest::getInstance()->getRequestParameters()->count());
        
        for ($i = 0; $i < 10; $i++) {
            $_SERVER['QUERY_STRING'] .= "/foo{$i}/bazValue{$i}";            
        }

        PlainHttpRequest::getInstance()->kill();
        PlainHttpRequest::getInstance()->dispatch($this->webdir);
        $this->assertEquals(12, PlainHttpRequest::getInstance()->getRequestParameters()->count());
        $this->assertEquals('Hélio Costa', PlainHttpRequest::getInstance()->getGetParameter('baz')->__toString());
        $this->assertEquals('123456', PlainHttpRequest::getInstance()->getParameter('foo')->__toString());
        $this->assertNull(PlainHttpRequest::getInstance()->getGetParameter('joker!'));
        $this->assertNotNull(PlainHttpRequest::getInstance()->getGetParameter('foo1'));
        $this->assertNotNull(PlainHttpRequest::getInstance()->getParameter('foo1'));
        $this->assertNull(PlainHttpRequest::getInstance()->getParameter('jokerAgain!'));
    }
    
    /**
     * Test Post Parameters
     */
    public function testPostParameters() {
        $_POST['foo'] = 'baz';
        $_SERVER['QUERY_STRING'] = 'request=modulo/foobar/';
        
        PlainHttpRequest::getInstance()->dispatch($this->webdir);
        $this->assertEquals('baz', PlainHttpRequest::getInstance()->getPostParameter('foo')->__toString());
        $this->assertEquals('baz', PlainHttpRequest::getInstance()->getParameter('foo')->__toString());
        $this->assertNull(PlainHttpRequest::getInstance()->getPostParameter('somethingStrange'));
        
        $_POST['foo'] = array('baz' => 'lol', 1 => 'the number one !');
        $_POST['baz'] = 'Single Element';
        $_POST['mandrake'] = array('try' => array('to' => array('trace' => 'me')), 'simple' => 'test');
        
        PlainHttpRequest::getInstance()->kill();
        PlainHttpRequest::getInstance()->dispatch($this->webdir);
        $this->assertEquals('lol', PlainHttpRequest::getInstance()->getPostParameter('foo')->offsetGet('baz')->__toString());
        $this->assertEquals('lol', PlainHttpRequest::getInstance()->getParameter('foo')->offsetGet('baz')->__toString());
        $this->assertEquals('Single Element', PlainHttpRequest::getInstance()->getParameter('baz')->__toString());
        $this->assertEquals('Single Element', PlainHttpRequest::getInstance()->getPostParameter('baz')->__toString());
        $this->assertEquals('test', PlainHttpRequest::getInstance()->getParameter('mandrake')->offsetGet('simple')->__toString());
        $this->assertEquals('me', PlainHttpRequest::getInstance()->getParameter('mandrake')->offsetGet('try')->offsetGet('to')->offsetGet('trace')->__toString());
    }
}

