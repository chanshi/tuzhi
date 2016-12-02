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
     * @var
     */
    public $advance=[];

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $advanceList
     * @return bool
     */
    protected function prepare( $advanceList = null )
    {
        $advanceList = $advanceList == null
            ? $this->route->advance
            : $advanceList;


        foreach( $advanceList as $name) {
            if( !isset($this->advance[$name]) ) continue;
            $AdvanceClass = \Tuzhi::make($this->advance[$name]);
            if( ! $AdvanceClass->handler( $this->route ) ){
                $this->content = $AdvanceClass->getResponse();
                return false;
            }
        }
        return true;
    }

}