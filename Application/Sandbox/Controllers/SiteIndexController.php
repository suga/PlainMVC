<?php
namespace Application\Sandbox\Controllers;

use Library\PlainMVC\Core;
use Library\PlainMVC\Core\View\PlainHttpRequest, Application\Sandbox, Library\DoctrineConfig;


class SiteIndexController {

    /**
     * Index action for sandbox
     * @internal url: http://yoursite/index/sandbox
     * @param $request
     */
    public function indexAction(PlainHttpRequest $request) {
        $address = new Sandbox\Address();
        $user = new Sandbox\User();
        
        echo 'Por enquanto, tudo oka !';
        
        $user = new Sandbox\User();
        $user->setName('Garfield');
        
        DoctrineConfig::getInstance()->persist($user);
        DoctrineConfig::getInstance()->flush();

        $user = new Sandbox\User();
        $user->setName('Helio');
        
        DoctrineConfig::getInstance()->persist($user);
        DoctrineConfig::getInstance()->flush();
        
        echo "User saved!";
        /* @var $garfield \Application\Sandbox\User */
        $garfield = DoctrineConfig::getInstance()->find('\Application\Sandbox\User', 1);
        $userRepository  = DoctrineConfig::getInstance()->getRepository('\Application\Sandbox\User');
        
        $hlegius = new \ArrayObject($userRepository->findByName('Helio'));
        
        echo '<p>&nbsp;</p>';
        echo "The first username is called as {$garfield->getName()}<br />";
        echo "The user hlegius is called as {$hlegius->offsetGet(0)->getName()}";
        
        $configs = Core\PlainConfig::getInstance()->getApplicationConfig();
        var_dump($configs['type']);
    }
}
