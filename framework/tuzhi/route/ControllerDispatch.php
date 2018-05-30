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
use tuzhi\route\exception\NotFoundPage;

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
    public $controlNamespace = 'app\\control';

    /**
     * @var
     */
    protected $control;

    /**
     * @var
     */
    protected $action;

    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();

        list($this->control,$this->action) = explode('@',$this->route->getAction());
        $this->control = $this->createControl($this->control);
        $this->action  = $this->prepareAction($this->action);
    }

    /**
     * @throws NotFoundMethodException
     */
    public function dispatch()
    {
        $this->prepare()
        && $this->getControlContent();
    }

    /**
     * @return mixed
     */
    protected function getControlContent()
    {
        $this->prepare( $this->control->getAdvances( $this->action ) )
        && $this->getActionContent();
    }

    /**
     * @throws NotFoundPage
     */
    protected function getActionContent()
    {
        if( $this->control->hasAct( $this->action ) ){
            //TODO: 匹配参数的问题
            $this->content = call_user_func_array([$this->control ,$this->action],[]);
        }else{
            //TODO:: Not Found Page
            throw new NotFoundPage( 'Not Found Action '.$this->action.' In Control '.$this->control );
        }
    }

    /**
     * @param $control
     * @return mixed
     * @throws NotFoundPage
     */
    protected function createControl( $control )
    {
        if( strpos($control ,'<') !== false) {
            $control = $this->defaultControlName;
        }

        $control = $this->controlNamespace.'\\'. ucfirst(  $control  );

        if( class_exists( $control ) ){
            return  Tuzhi::make( $control );
        }else{
            throw new NotFoundPage('Not Found Control '.$control);
        }
    }

    /**
     * @param $action
     * @return string
     */
    protected function prepareAction( $action )
    {
        if( strpos($action,'<') !== false){
            $action = $this->defaultActionName;
        }
        return $action.'Action';
    }

}