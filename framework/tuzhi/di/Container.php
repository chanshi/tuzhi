<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 15:32
 */

namespace tuzhi\di;

/**
 * 容器  依赖注入
 *
 * Class Container
 * @package tuzhi\di
 */
class Container
{
    /**
     * @var null
     */
    private static $instance = null;

    /**
     * 类定义体
     * @var
     */
    protected $definition;

    /**
     * 缓存 反射类
     * @var
     */
    protected $reflection;

    /**
     * 缓存 类依赖信息
     * @var
     */
    protected $dependent;


    /**
     * @var
     */
    protected $container;


    /**
     * @return Container
     */
    public static function getInstance()
    {
        if( static::$instance == null ){
            static::$instance = new static();
        }
        return static::$instance;
    }


    /**
     * 
     * @param $name
     * @param array $param
     * @return mixed|null
     */
    public function get( $name ,$param = [] )
    {
        if( isset($this->container[$name]) ){
            return $this->container[$name];
        }
        if( ! isset( $this->definition[$name] ) ){
            return $this->build($name,$param);
        }

        $definition = $this->definition[$name];

        if( is_object($definition) ){
            $this->container[$name] = $definition;
            return $definition;
        }

        if( is_array($definition)){
            $class = $definition['class'];
            unset($definition['class']);

            $object = null;

            if( $name === $class ){
                $object = $this->get($class ,$definition);
            }else{
                $object = $this->build($class,$definition);
            }

            $this->container[$name] = $object;

            return $object;
        }
        //TODO: 异常
    }

    /**
     * set( 'db' ,[] )
     * set( 'interface' ,'class')
     * set( 'class' , values)
     * set( 'name' ,function(){} )
     *
     * 设置定义体
     *
     * @param $class
     * @param array $definition
     */
    public function set( $class ,$definition = [] )
    {
        $this->definition[$class] = $this->normalizeDefinition($class ,$definition);
    }


    /**
     * @param $class
     * @param $params
     * @return mixed
     */
    public function build($class ,$params )
    {
        list( $reflection ,$dependent ) = $this->getDependent($class);

        foreach( $params as $index=>$value ){
            $dependent[$index] = $value;
        }

        $dependent = $this->resolveDependent($dependent,$reflection);

        return $reflection->newInstanceArgs($dependent);
    }


    /**
     * @param $class
     * @return array
     */
    public function getDependent( $class ) {
        // 缓存
        if( $this->reflection[$class] ){
            return [ $this->reflection[$class] ,$this->dependent[$class] ];
        }

        $reflection = new \ReflectionClass($class);
        $dependent = [];

        $constructor = $reflection->getConstructor();

        if( $constructor !== null ){
            foreach( $constructor->getParameters()  as $param ){
                if( $param->isDefaultValueAvailable() ){
                    $dependent[] = $param->getDefaultValue();
                }else {
                    $c = $param->getClass() ;
                    $dependent[] = Instance::set( $c == null ? null : $c->getName() );
                }
            }
        }

        $this->reflection[$class] = $reflection;
        $this->dependent[$class] = $dependent;

        return [$reflection,$dependent];
    }

    /**
     * @param $dependent
     * @param null $reflection
     * @return Instance
     */
    public function resolveDependent( $dependent ,$reflection = null )
    {
        foreach( $dependent as $index=>$depend ) {
            if( $dependent instanceof  Instance ){
                if( $dependent->name ){
                    $dependent[$index] = $dependent->get();
                }else if( $reflection != null ){
                    //TODO: 抛出异常
                    $method = $reflection->getConstructor()->getParameters()[$index]->getName();
                    $class = $reflection->getName();
                }
            }
        }
        return $dependent;
    }

    /**
     * 规范 定义体
     *
     * @param $class
     * @param $definition
     * @return array
     */
    protected function normalizeDefinition( $class , $definition )
    {

        if( empty( $definition ) ){

            return ['class'=>$class];

        }else if( is_string( $definition ) ) {

            return ['class'=>$definition ];

        }else if( is_array( $definition ) ) {
            if( ! isset( $definition['class'] ) ){
                //检查 class 是否是类名
                if( strpos($class ,'\\') !==false ){
                    $definition['class'] = $class;
                }else{
                    //TODO: 抛出异常  没有类定义
                }
            }
            return $definition;
        }else {
            //TODO:  抛出异常
        }
    }

}