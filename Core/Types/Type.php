<?php
namespace Library\PlainMVC\Core\Types;
/**
 * Default Type
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Plain\core\types
 * @version January 16, 2010
 */
abstract class Type {
    protected $content;
    
    /**
     * Constructor
     * @param mixed $mixed
     */
    public function __construct($mixed) {
        $this->content = $mixed;
    }
    
    /**
     * Return md5 content hash
     * @return string
     */
    public function hash() {
        return md5($this->content);
    }
    
    /**
     * Returns the string
     * @return string
     */
    public function __toString() {
        return (string)$this->content;
    }
    
    /**
     * Compare two contents
     * @param mixed $otherContent
     * @return boolean
     */
    abstract public function equals($otherContent);
}
