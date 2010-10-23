<?php
/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
abstract class Twig_Resource {

    protected $env;

    public function __construct(Twig_Environment $env) {
        $this->env = $env;
    }

    public function getEnvironment() {
        return $this->env;
    }

    protected function resolveMissingFilter($name) {
        throw new Twig_RuntimeError(sprintf('The filter "%s" does not exist', $name));
    }

    /**
     * Search for public methods on an Object for display in template
     * @author Fabien Potencier
     * @author Hélio Costa e Silva <hlegius@gmail.com>
     * @param stdObject $object
     * @param mixed $item
     * @param array $arguments
     * @param boolean $arrayOnly
     */
    protected function getAttribute($object, $item, array $arguments = array(), $arrayOnly = false) {
        if (is_object($object)) {
            $arrAllowedPrefixes = array('get', 'has', 'is', 'match', 'contain');
            $reflection = new ReflectionObject($object);
            
            foreach ($arrAllowedPrefixes as $prefix) {
                if (strpos($item, $prefix) !== 0) { /* if isn't at first position, try next */
                    continue;
                }
                if ($reflection->hasMethod($item)) {
                    $reflectionMethod = new ReflectionMethod($object, $item);
                    
                    if ($reflectionMethod->isPublic()) {
                        if ($reflectionMethod->getNumberOfParameters() > 0) {
                            return $reflectionMethod->invokeArgs($object, $arguments);
                        } else {
                            return $object->{$item}();
                        }
                    } else {
                        return null;
                    }
                }
            }
        }
        $item = (string)$item;
        
        if ((is_array($object) || is_object($object) && $object instanceof ArrayAccess) && isset($object[$item])) {
            return $object[$item];
        }
        
        if ($arrayOnly) {
            return null;
        }
        
        if (is_object($object) && isset($object->$item)) {
            if ($this->env->hasExtension('sandbox')) {
                $this->env->getExtension('sandbox')->checkPropertyAllowed($object, $item);
            }
            
            return $object->$item;
        }
        
        /* @todo helio.costa __get __isset
         * __get() __isset() support. Still here for a while */
        if (!is_object($object) || (!method_exists($object, $method = $item) && !method_exists($object, $method = 'get' . $item))) {
            return null;
        }
        
        if ($this->env->hasExtension('sandbox')) {
            $this->env->getExtension('sandbox')->checkMethodAllowed($object, $method);
        }
        
        $reflection = new ReflectionObject($object);
        
        if ($reflection->hasMethod('__get')) {
            return call_user_func_array(array($object, $method), $arguments);
        }
    }
}
