<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:51
 */

namespace tuzhi\route;
use tuzhi\base\Object;


/**
 * 控制器
 * 
 * Class Controller
 * @package tuzhi\route
 */
class Controller extends Object
{
    /**
     * @var array
     */
    protected $actionClass = [];

    /**
     * @param $action
     * @param $arguments
     */
    public function __call( $action,$arguments)
    {
        $action = strtolower($action);
        if(array_key_exists($action,$this->actionClass)){
            $action = \Tuzhi::make(
                $this->actionClass[$action]
            );
            return $action->action();
        }
        //TODO:: NOT FOUND
    }
}