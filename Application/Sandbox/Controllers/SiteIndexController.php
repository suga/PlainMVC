<?php
namespace Application\Sandbox\Controllers;

use Library\PlainMVC\Core\View\PlainHttpRequest, Application\Sandbox, Library\DoctrineConfig;

class SiteIndexController {

    public function indexAction(PlainHttpRequest $request) {
        $address = new Sandbox\Address();
        $user = new Sandbox\User();
        
        echo 'Por enquanto, tudo oka !';
        
        $user = new Sandbox\User();
        $user->setName('Hélio');
        
        DoctrineConfig::getInstance()->persist($user);
        DoctrineConfig::getInstance()->flush();
        
        echo "User saved!";
        /* @var $garfield \Application\Sandbox\User */
        $garfield = DoctrineConfig::getInstance()->find('\Application\Sandbox\User', 1);
        $userRepository  = DoctrineConfig::getInstance()->getRepository('\Application\Sandbox\User');
        
        $hlegius = new \ArrayObject($userRepository->findByName('Hélio'));
        
        echo '<p>&nbsp;</p>';
        echo "Nome do primeiro usuário é {$garfield->getName()}<br />";
        echo "Usuário hlegius chama-se: {$hlegius->offsetGet(0)->getName()}";
    }
}
