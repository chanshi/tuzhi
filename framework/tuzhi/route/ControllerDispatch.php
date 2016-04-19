<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/11
 * Time: 20:48
 */

namespace tuzhi\route;
use tuzhi\base\exception\NotFoundMethodException;
use tuzhi\contracts\route\IDispatch;

/**
 * 
 * Class ControllerDispatch
 * @package tuzhi\route
 */
class ControllerDispatch implements IDispatch
{

    /**
     * @var
     */
    public $route;

    /**
     * @var
     */
    public $content;

    /**
     * @var string
     */
    protected $defaultControlName = 'Index';

    /**
     * @var string
     */
    protected $defaultActionName = 'Index';

    /**
     * @var string
     */
    protected $controlNamespace = 'app\control';

    /**
     * ControllerDispatch constructor.
     * @param $route
     */
    public function __construct( $route )
    {
        $this->route = $route;
    }

    /**
     * @throws NotFoundMethodException
     */
    public function dispatch()
    {
        list($control ,$action) = explode('@',$this->route->getAction());

        $Control = $this->makeControl($control);

        $action  = $this->prepareAction($action);

        if( method_exists( $Control , $action ) ){
            //TODO: 匹配参数的问题
            $this->content = call_user_func_array([$Control ,$action],[]);
        }else{
            throw new NotFoundMethodException( 'Not Found Action '.$action.' In Control '.$control );
        }
    }

    /**
     * @param $control
     * @return mixed
     */
    public function makeControl( $control )
    {
        if( strpos($control ,'<') !== false) {
            $control = $this->defaultControlName;
        }
        //首字母大写把
        $control =ucfirst( strtolower( $control )  );
        
        return \Tuzhi::make( $this->controlNamespace.'\\'.$control );
    }

    /**
     * @param $action
     * @return string
     */
    public function prepareAction( $action )
    {
        if( strpos($action,'<') !== false){
            $action = $this->defaultActionName;
        }
        return $action.'Action';
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}