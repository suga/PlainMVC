PlainMVC - A MVC that uses Convention over Configuration (CoC) paradigm
=======

PlainMVC has focus on simplicity, speed and no more many config files :)
PlainMVC uses Twig as default Template Engine and Doctrine 2.x as ORM engine, so PHP 5.3 or above is required !

For example, you can have a decoupled Controller without inheritance or interface. IoC Principles was used to make it possible in PlainMVC.


    class FoobarController {

        public function someMethodAction(PlainHttpRequest $request, PlainHttpResponse $response) {
            $user = new Sandbox\User();
            $user->setName('Garfield');
        
            DoctrineConfig::getInstance()->persist($user);
            DoctrineConfig::getInstance()->flush(); // saves user
            
            $garfield = DoctrineConfig::getInstance()->find('\Application\Sandbox\User', 1);
            
            $response->getView()->append('user', $garfield); // <-- send to Twig Sandbox\User object
            $response->getView()->render('yourtemplate.tpl');
        }
    }

Only with this, you can display your "yourtemplate.tpl" file in some module. PlainHttpRequest and PlainHttpResponse are injected by PlainRequest
dispatcher on the fly.

Default Page:
PlainMVC looking for some Controller called DefaultIndexController with indexAction() public method. If found, PlainMVC will displays this method every
time when no module or action be setted via URL. For example: -- http://yourserver/Plainmvc/web; -- http://yourserver/Plainmvc/web/index;
-- http://yourserver/Plainmvc/web/index/module.    

PlainMVC has the following directories structure:

/application
    - yourFirstModule
        - controllers
            - here you can have one or more controllers. You choose how many you want !
        - views
            - here you put your templates files for this module
        - SomeDomainClass.php
        - OtherDomainClass.php
        - ...
        
    - otherModule
        - ...
    - ...
/config
    - PlainMVC do NOT need this directory. You can use it for your own configs
/library
    - PlainMVC and their dependencies (includes Doctrive v2)
/log
    - assertion fails log and more
/tmp
    - tpl_cache
        - Twig template cache
/web
    - index.php <- default
    /admin
        - index.php <- yes, you can have other directories with owns Controllers. 
                        For it works, you only need to name your Controller as: SomeName{DirectoryName}Controller.php
                        For example: FoobarAdminController.php and done !
        /bar
            - index.php <- it's recursive too! Controller File: SomeNameAdminBarController.php
            
For more examples, you can read Controllers files at /application/modulo/controllers/ and runs the examples.
The URL will like something like as: 
    http://yourserver/index/yourModuleName/yourActionName
or, if you need GET parameters:
    http://yourserver/index/yourModuleName/yourActionName/yourGetKey/your Get Value/yourOtherGetKey/yourOtherValue