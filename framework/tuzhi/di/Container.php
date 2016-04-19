<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 15:32
 */

namespace tuzhi\di;
use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\exception\NotFoundMethodException;

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
     * @param $name
     * @param array $param
     * @param array $config
     * @return mixed|null
     * @throws InvalidParamException
     */
    public function get( $name ,$param = [] ,$config= [])
    {
        if( isset($this->container[$name]) ){
            return $this->container[$name];
        }
        if( ! isset( $this->definition[$name] ) ){
            return $this->build($name,$param ,$config);
        }

        $definition = $this->definition[$name];

        if( is_object($definition) ){
            $this->container[$name] = $definition;
            return $definition;
        }

        if( is_array($definition)){
            $class = $definition['class'];
            unset($definition['class']);

            $config = array_merge( $definition ,$config );
            $object = null;

            if( $name === $class ){
                $object = $this->get( $name ,$param ,$config);
            }else{
                $object = $this->build( $class ,$param ,$config);
            }

            $this->container[$name] = $object;

            return $object;
        }

        throw new InvalidParamException( 'Invalid Param Not Found Class Or Definition' );
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
     * @param $config
     * @return mixed
     */
    public function build($class ,$params ,$config)
    {
        list( $reflection ,$dependent ) = $this->getDependent($class);

        foreach( $params as $index=>$value ){
            $dependent[$index] = $value;
        }

        $dependent = $this->resolveDependent($dependent,$reflection);
        
        if( empty( $config) ){

            return $reflection->newInstanceArgs ($dependent);
        }

        if( !empty($dependent) && $reflection->implementsInterface('tuzhi\contracts\base\IObject') ){
            $dependent[count($dependent) - 1] = $config;
            return $reflection->newInstanceArgs($dependent);
        }else{
            $instance = $reflection->newInstanceArgs($dependent);
            foreach( $config as $key=>$value )
            {
                $instance->{$key} = $value;
            }
            return $instance;
        }
    }


    /**
     * @param $class
     * @return array
     */
    public function getDependent( $class ) {
        // 缓存
        if( isset( $this->reflection[$class] ) ){
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
     * @throws NotFoundMethodException
     */
    public function resolveDependent( $dependent ,$reflection = null )
    {
        foreach( $dependent as $index=>$depend ) {
            if( $dependent instanceof  Instance ){
                if( $dependent->name ){
                    $dependent[$index] = $dependent->get();
                }else if( $reflection != null ){

                    $method = $reflection->getConstructor()->getParameters()[$index]->getName();
                    $class = $reflection->getName();

                    throw new NotFoundMethodException('The '.$class.' Not Found Method '.$method.' In Container::resolvDependent ');
                }
            }
        }
        return $dependent;
    }

    /**
     * @param $class
     * @param $definition
     * @return array
     * @throws InvalidParamException
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
                    throw new InvalidParamException( 'Invalid Param Class not definition ');
                }
            }
            return $definition;
        }else {
            throw new InvalidParamException( 'Invalid Param '.$class.' And Param '.$definition.'' );
        }
    }

}