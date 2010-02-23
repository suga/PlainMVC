<?php
/**
 * NotFound Action method Controller
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\simplemvc\core\view
 * @version January, 17 2010
 */
final class SimpleNotFoundActionController {

    /**
     * Intercepter methods
     * @param string $classNotFound
     * @param array(SimpleHttpRequest) $request
     */
    public function __call($classNotFound, array $request) {
        /* @var $response SimpleHttpResponse */
        $response = $request[1];
        /* @var $request SimpleHttpRequest */
        $request = $request[0];
        
        /** @todo helio.costa -- logar action exception e zaz */
        
        echo 'Página não encontrada';
    }

}
