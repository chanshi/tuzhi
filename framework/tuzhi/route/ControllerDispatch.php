<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/11
 * Time: 20:48
 */

namespace tuzhi\route;

use Tuzhi;
use tuzhi\base\exception\NotFoundMethodException;
use tuzhi\contracts\route\IDispatch;

/**
 * 
 * Class ControllerDispatch
 * @package tuzhi\route
 */
class ControllerDispatch extends Dispatcher implements IDispatch
{

    /**
     * @var string
     */
    public $defaultControlName = 'Index';

    /**
     * @var string
     */
    public $defaultActionName = 'Index';

    /**
     * @var string
     */
    public $controlNamespace = 'app\control';



    /**
     * @throws NotFoundMethodException
     */
    public function dispatch()
    {
        $this->frontCheck();

        if( ! $this->hasContent() ){
            $this->getControlContent();
        }
    }

    /**
     * @throws NotFoundMethodException
     */
    protected function getControlContent()
    {
        list($control ,$action) = explode('@',$this->route->getAction());

        $Control = $this->makeControl($control);

        $action  = $this->prepareAction($action);

        if( $Control->hasAct( $action ) ){
            //TODO: 匹配参数的问题
            $this->content = call_user_func_array([$Control ,$action],[]);
        }else{
            throw new NotFoundMethodException( 'Not Found Action '.$action.' In Control '.$control );
        }
    }

    /**
     * @param $control
     * @return mixed
     * @throws NotFoundMethodException
     */
    public function makeControl( $control )
    {
        if( strpos($control ,'<') !== false) {
            $control = $this->defaultControlName;
        }

        $control = $this->controlNamespace.'\\'. ucfirst( strtolower( $control )  );

        if( class_exists( $control ) ){
            return  Tuzhi::make( $control );
        }else{
            throw new NotFoundMethodException('Not Found Control '.$control);
        }
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

}