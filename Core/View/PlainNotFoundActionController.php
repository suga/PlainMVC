<?php
namespace Library\PlainMVC\Core\View;
/**
 * NotFound Action method Controller
 * @author Hélio Costa e Silva <hlegius@yahoo.com.br>
 * @package \library\Plainmvc\core\view
 * @version January, 17 2010
 */
final class PlainNotFoundActionController {

    /**
     * Intercepter methods
     * @param string $classNotFound
     * @param array(PlainHttpRequest) $request
     */
    public function __call($classNotFound, array $request) {
        /* @var $response PlainHttpResponse */
        $response = $request[1];
        /* @var $request PlainHttpRequest */
        $request = $request[0];
        
        /** @todo helio.costa -- logar action exception e zaz */
        
        echo 'Página não encontrada';
    }

}
