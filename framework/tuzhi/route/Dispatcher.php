<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/2
 * Time: 17:50
 */

namespace tuzhi\route;


use tuzhi\base\Object;
use tuzhi\helper\Arr;

/**
 * Class Dispatcher
 * @package tuzhi\route
 */
class Dispatcher extends Object
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
     * @var
     */
    public $request;

    /**
     * @var array
     */
    public $checkList = [];

    /**
     * init
     */
    public function init()
    {
        //TODO:: 这个
        if( \Tuzhi::config('router.frontCheck') ){
            $this->checkList = \Tuzhi::config('router.frontCheck');
        }
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    protected function hasContent()
    {
        return  empty( $this->content )
            ? false
            : true;
    }

    /**
     * @return bool
     */
    public function frontCheck()
    {
        // 合并 checklist;

        Arr::each($this->checkList,function($keys,$value){

            $this->content = \Tuzhi::make( $value )->handle( $this->route ,$this->request);
            if( $this->content ){
                return false;
            }
        });

    }


}