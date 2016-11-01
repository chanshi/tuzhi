<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:51
 */

namespace tuzhi\route;
use tuzhi\base\exception\NotFoundMethodException;
use tuzhi\base\Object;


/**
 * 控制器
 * 
 * Class Controller
 * @package tuzhi\route
 */
class Controller extends Object
{
    protected $front = [];
    /**
     * @var array
     */
    protected $actionClass = [];

    /**
     * @param $action
     * @param $arguments
     * @return mixed
     * @throws NotFoundMethodException
     */
    public function __call( $action,$arguments)
    {
        //$action = strtolower($action);
        if(array_key_exists($action,$this->actionClass)){
            $action = \Tuzhi::make(
                $this->actionClass[$action]
            );
            return $action->action();
        }
        throw new NotFoundMethodException('Not Found Action');
        //TODO:: NOT FOUND
    }

    public function hasAct( $action )
    {
        return method_exists($this,$action) || array_key_exists($action,$this->actionClass);
    }
}