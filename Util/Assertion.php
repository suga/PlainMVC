<?php
namespace Library\PlainMVC\Util;

use Library\PlainMVC\Internals\Spyc\Spyc;
use Library\PlainMVC\Core\PlainConfig;

/**
 * Assertion class
 * @author Hélio Costa e Silva <hlegius@foobug.com.br>
 * @package \library\Plain\util
 * @version January, 23 2010
 */

class Assertion {
    /**
     * Assertion status
     * @var string
     */
    private $status = Assertion::ENABLED;
    /**
     * YML configuration
     * @var unknown_type
     */
    private static $rootconfig = null;
    /**
     * Assert conditional
     * @var mixed
     */
    protected $condition;
    /**
     * User-provided details
     * @var string
     */
    protected $details;
    /**
     * Enabled assertion value
     * @var string
     */
    const ENABLED = "on";
    /**
     * Disabled assertion value
     * @var string
     */
    const DISABLED = "off";

    
    /**
     * Initialize assertion class
     * @return void
     */
    public function __construct() {
        if (is_null(self::$rootconfig)) {
            $spyc = new Spyc();
            self::$rootconfig = $spyc->loadFile(PlainConfig::getInstance()->getConfigDirectory() . DIRECTORY_SEPARATOR . 'root.yml');
        }

        $this->status = self::$rootconfig['Plain']['assert_' . self::$rootconfig['Plain']['application']];
        
        if ($this->getStatus() == self::ENABLED) {
            assert_options(ASSERT_ACTIVE, 1);
            assert_options(ASSERT_WARNING, 0);
            assert_options(ASSERT_BAIL, 0);
            assert_options(ASSERT_CALLBACK, array(__CLASS__, 'fail'));
        } else {
            assert_options(ASSERT_ACTIVE, 0);            
        }
    }
    
    /**
     * Runs assertion condition
     * @param string $condition
     * @return void
     */
    public function assert($condition, $details) {
        if ($this->getStatus() == Assertion::ENABLED) {
            $this->details = $details;
            $this->condition = $condition;
            assert($condition);            
        }
    }
    
    /**
     * Throws assertion fails message
     * @return void
     */
    public function fail($file, $line, $code) {
        if ($this->getStatus() != Assertion::ENABLED) {
            return ;
        }
        throw new AssertionException($this->condition, $this->details);
    }
    
    /**
     * Assertion status
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }
}
