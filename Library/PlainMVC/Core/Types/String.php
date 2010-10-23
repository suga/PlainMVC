<?php
namespace Library\PlainMVC\Core\Types;
/**
 * String type
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Plain\core\types
 * @version January, 16 2010
 */
final class String extends Type {
        
    /**
     * Compare 2 strings
     * @param string $otherContent
     * @return boolean
     */
    public function equals($otherContent) {
        return ($this->content === $otherContent);
    }
    
    /**
     * String to lower case
     * @return string
     */
    public function toLower() {
        return strtolower($this->accentuationToLower());
    }
    
    /**
     * String to uppercase
     * @return string
     */
    public function toUpper() {
        return strtoupper($this->accentuationToUpper());
    }
    
    /**
     * Trim string
     * @return string
     */
    public function trim() {
        return trim($this->content);
    }
    
    /**
     * Converts accentuation letters to lower case
     * @return string
     */
    private function accentuationToLower() {
        $str_temp = str_replace('Á', 'á', $this->content);
        $str_temp = str_replace('À', 'à', $str_temp);
        $str_temp = str_replace('Ã', 'ã', $str_temp);
        $str_temp = str_replace('Â', 'â', $str_temp);
        $str_temp = str_replace('É', 'é', $str_temp);
        $str_temp = str_replace('È', 'è', $str_temp);
        $str_temp = str_replace('Ê', 'ê', $str_temp);
        $str_temp = str_replace('Ë', 'ë', $str_temp);
        $str_temp = str_replace('Í', 'í', $str_temp);
        $str_temp = str_replace('Ì', 'ì', $str_temp);
        $str_temp = str_replace('Ï', 'ï', $str_temp);
        $str_temp = str_replace('Ó', 'ó', $str_temp);
        $str_temp = str_replace('Ò', 'ó', $str_temp);
        $str_temp = str_replace('Õ', 'õ', $str_temp);
        $str_temp = str_replace('Ô', 'ô', $str_temp);
        $str_temp = str_replace('Ú', 'ú', $str_temp);
        $str_temp = str_replace('Ù', 'ù', $str_temp);
        $str_temp = str_replace('ü', 'ü', $str_temp);
        $str_temp = str_replace('Ç', 'ç', $str_temp);
        
        return $str_temp;
    }
    
    /**
     * Converts accentuation letter to upper case
     * @return string
     */
    private function accentuationToUpper() {
        $str_temp = str_replace('á', 'Á', $this->content);
        $str_temp = str_replace('à', 'À', $str_temp);
        $str_temp = str_replace('ã', 'Ã', $str_temp);
        $str_temp = str_replace('â', 'Â', $str_temp);
        $str_temp = str_replace('é', 'É', $str_temp);
        $str_temp = str_replace('è', 'È', $str_temp);
        $str_temp = str_replace('ê', 'Ê', $str_temp);
        $str_temp = str_replace('ë', 'Ë', $str_temp);
        $str_temp = str_replace('í', 'Í', $str_temp);
        $str_temp = str_replace('ì', 'Ì', $str_temp);
        $str_temp = str_replace('ï', 'Ï', $str_temp);
        $str_temp = str_replace('ó', 'Ó', $str_temp);
        $str_temp = str_replace('ó', 'Ò', $str_temp);
        $str_temp = str_replace('õ', 'Õ', $str_temp);
        $str_temp = str_replace('ô', 'Ô', $str_temp);
        $str_temp = str_replace('ú', 'Ú', $str_temp);
        $str_temp = str_replace('ù', 'Ù', $str_temp);
        $str_temp = str_replace('ü', 'ü', $str_temp);
        $str_temp = str_replace('ç', 'Ç', $str_temp);
        
        return $str_temp;        
    }
    
    /**
     * Removes accentuation
     * @return string
     * @todo implementar :)
     */
    public function accentuationStrip() {
        $str_temp = str_replace('á', 'Á', $this->content);
        $str_temp = str_replace('à', 'À', $str_temp);
        $str_temp = str_replace('ã', 'Ã', $str_temp);
        $str_temp = str_replace('â', 'Â', $str_temp);
        $str_temp = str_replace('é', 'É', $str_temp);
        $str_temp = str_replace('è', 'È', $str_temp);
        $str_temp = str_replace('ê', 'Ê', $str_temp);
        $str_temp = str_replace('ë', 'Ë', $str_temp);
        $str_temp = str_replace('í', 'Í', $str_temp);
        $str_temp = str_replace('ì', 'Ì', $str_temp);
        $str_temp = str_replace('ï', 'Ï', $str_temp);
        $str_temp = str_replace('ó', 'Ó', $str_temp);
        $str_temp = str_replace('ó', 'Ò', $str_temp);
        $str_temp = str_replace('õ', 'Õ', $str_temp);
        $str_temp = str_replace('ô', 'Ô', $str_temp);
        $str_temp = str_replace('ú', 'Ú', $str_temp);
        $str_temp = str_replace('ù', 'Ù', $str_temp);
        $str_temp = str_replace('ü', 'ü', $str_temp);
        $str_temp = str_replace('ç', 'Ç', $str_temp);
        
        return $str_temp;        
    }
    
    public function toUrl() { }
    
    public function fromUrl() { }
}
