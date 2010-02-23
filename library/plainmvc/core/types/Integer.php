<?php
/**
 * Integer type class
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Plain\core\types
 * @version January, 16 2010
 */
final class Integer extends Numeric {
    
    /**
     * Compare two values
     * @param integer $otherValue
     * @return boolean
     */
    public function equals($otherContent) {
        return ($this->content === settype($otherContent, 'int'));
    }
}
