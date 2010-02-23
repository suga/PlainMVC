<?php
/**
 * Domain data Repository
 * @author Hélio Costa e Silva <hlegius@foobug.com.br>
 * @package \library\Plain\util
 * @version January, 23 2010
 *
 */
final class Repository {
    /**
     * Outlet ORM
     * @var Outlet
     */
    private static $orm;
    
    
    /**
     * Domain Repository Constructor
     */
    public function __construct() {
        if (!self::$orm instanceof Outlet) {
            Outlet::init(OrmConfig::load());
            self::$orm = Outlet::getInstance();
            self::$orm->createProxies();
        }
    }
    
    /**
     * Save or update an object
     * @param Object &$object
     * @internal by reference
     */
    public function save(&$object) {
        self::$orm->save($object);
    }
    
    public function __call($method, array $args) {
        return self::$orm->{$method}($args);
    }
    
    public function getOrm() {
        return self::$orm;
    }
    
    /**
     * Drop an object
     * @param Object $object
     * @throws RepositoryException
     * @return void
     */
    public function delete(&$object) {
        $class = get_class($object);
        $reflection = new ReflectionObject($class);
        /* @var $pkMethod ReflectionMethod */
        $pkMethod = $reflection->getMethod('getId');
        
        if ($pkMethod instanceof ReflectionMethod) {
            self::$orm->delete($class, $class->{$pkMethod->getName()}());
            return ;            
        }
        
        // looking for "property annotation"
        $classProperties = $reflection->getProperties();
        /* @var $property ReflectionProperty */
        foreach ($classProperties as $property) {
            if (strpos($property->getDocComment(), "@primarykey")) {
                /* @var $pkMethod ReflectionMethod */
                $pkMethod = $reflection->getMethod("get" . ucfirst($property->getName()));
                $assert = new Assertion();
                $assert->assert(!$pkMethod instanceof ReflectionMethod, "[System Failure] " . __CLASS__ . " @online " . __LINE__);
                
                try {
                    self::$orm->delete($class, $class->{$pkMethod->getName()}());
                } catch (OutletException $oute) {
                    throw new RepositoryException($oute);
                }
                break;
            }
        }
        throw new RepositoryException("Cannot find property or method with element's index (pk)");
    }
}