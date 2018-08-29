<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 14:51
 */

namespace tuzhi\route;

use tuzhi\base\BObject;
use tuzhi\route\exception\NotFoundPage;

/**
 * Class Controller
 * @package tuzhi\route
 */
class Controller extends BObject
{
    /**
     * @var array
     */
    protected $advanceHandle = [];

    /**
     * @var array
     */
    protected $actionClass = [];


    /**
     * @return mixed
     */
    public function goHome()
    {
        return '/';
    }

    /**
     * @param $action
     * @return array
     */
    public function getAdvances( $action )
    {
        $common = isset($this->advanceHandle['*'])
            ? $this->advanceHandle['*']
            : [];

        $special = isset($this->advanceHandle[$action])
            ? $this->advanceHandle[$action]
            : [];

        return array_merge($common,$special);
    }

    /**
     * @param $action
     * @return bool
     */
    public function hasAct( $action )
    {
        return method_exists( $this , $action)
        || array_key_exists( $action, $this->actionClass);
    }

    /**
     * @param $action
     * @param $arguments
     * @return mixed
     * @throws NotFoundPage
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function __call( $action,$arguments)
    {
        if(array_key_exists($action,$this->actionClass)){
            $action = \Tuzhi::make(
                $this->actionClass[$action]
            );
            return $action->action();
        }
        throw new NotFoundPage('Not Found Action');
        //TODO:: NOT FOUND
    }

}