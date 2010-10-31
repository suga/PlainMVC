<?php
namespace Application\Doctrine\Controllers;

use Library\PlainMVC\Core\View\PlainHttpRequest, Application\Doctrine, Library\DoctrineConfig;

class SiteIndexController {

    public function indexAction(PlainHttpRequest $request) {
        $address = new Doctrine\Address();
        $user = new Doctrine\User();
        
        echo 'Por enquanto, tudo oka !';
        
        $user = new Doctrine\User();
        $user->setName('Hélio');
        
        DoctrineConfig::getInstance()->persist($user);
        DoctrineConfig::getInstance()->flush();
        
        echo "User saved!";
        /* @var $garfield \Application\Doctrine\User */
        $garfield = DoctrineConfig::getInstance()->find('\Application\Doctrine\User', 1);
        $userRepository  = DoctrineConfig::getInstance()->getRepository('\Application\Doctrine\User');
        
        $hlegius = new \ArrayObject($userRepository->findByName('Hélio'));
        
        echo '<p>&nbsp;</p>';
        echo "Nome do primeiro usuário é {$garfield->getName()}<br />";
        echo "Usuário hlegius chama-se: {$hlegius->offsetGet(0)->getName()}";
    }
}
