<?php
namespace Library\PlainMVC\Util;
/**
 * Assertion Runtime Exception
 * @author Hélio Costa e Silva <hlegius@foobug.com.br>
 * @package \library\Plain\util
 * @version January, 23 2010
 */
class AssertionException extends \RuntimeException {

    /**
     * Constructor
     * @param string $message
     */
    public function __construct($condition, $details) {
        $path = realpath(dirname(__FILE__) . "/../../../" . "/log/");
        $logfile = $path . "/assert.log";
        
        if (!file_exists($logfile)) {
            touch($logfile);
            chmod($logfile, 0777);
        }

        if (is_writable($logfile)) {
            $log = '-- ' . date('D, d M Y H:i:s') . " --" . PHP_EOL;
            $log .= "[assert error] " . PHP_EOL;
            $log .= "Condition: " . $condition . PHP_EOL;
            $log .= "Details: " . $details . PHP_EOL;
            $log .= '-----------------------------------------------' . PHP_EOL . PHP_EOL;
            
            error_log($log, 3, $logfile);
        }
        parent::__construct($details, '69');
    }
}
