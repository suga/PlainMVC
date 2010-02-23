PlainMVC - A MVC that uses Convention over Configuration (CoC) paradigm
=======

PlainMVC has focus on simplicity, speed and no more many config files :)
PlainMVC uses Twig as default Template Engine.

For example, you can have a decoupled Controller without inheritance or interface. IoC Principles was used to make it possible in PlainMVC.


    class FoobarController {

        public function someMethodAction(SimpleHttpRequest $request, SimpleHttpResponse $response) {
            $response->getView()->render('yourtemplate.tpl');
        }
    }

Only with this, you can display your "yourtemplate.tpl" file in some module. SimpleHttpRequest and SimpleHttpResponse are injected by SimpleRequest
dispatcher on the fly.


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
    - PlainMVC and their dependencies
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
    http://yourserver/plainmvc/web/index/yourModuleName/yourActionName
or, if you need GET parameters:
    http://yourserver/plainmvc/web/index/yourModuleName/yourActionName/yourGetKey/your Get Value/yourOtherGetKey/yourOtherValue