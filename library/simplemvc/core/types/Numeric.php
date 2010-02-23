<?php
/**
 * Numeric types
 * @author hlegius
 * @package \library\Plain\core\types
 * @version January, 16 2010
 */
abstract class Numeric extends Type {

    /**
     * Format numeric types
     * @param numeric $format
     * @return Numeric
     */
    public function format($format) {
        return sprintf($format, $this->content);
    }
}
