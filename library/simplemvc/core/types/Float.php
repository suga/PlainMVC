<?php
/**
 * Float type
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Plain\core\types
 *
 */
class Float extends Numeric {
    
    /**
     * Constructor for Float values
     * @param $mixed
     */
    public function __construct($mixed) {
        $this->content = floatval($mixed);
    }
    
	/**
	 * Compare with other content
     * @param mixed $otherContent
     * @return boolean
     */
    public function equals($otherContent) {
        return ($this->content === $otherContent);
    }
}
