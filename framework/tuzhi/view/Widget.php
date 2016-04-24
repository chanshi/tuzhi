<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/20
 * Time: 11:00
 */

namespace tuzhi\view;

use Tuzhi;
use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\Object;

/**
 * Class Widget
 * @package tuzhi\view
 */
abstract class Widget extends Object
{

    /**
     * 堆栈
     * @var array
     */
    protected static $stack = [];

    protected static $view;

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * @param array $config
     * @return mixed
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public static function begin( $config = [] )
    {
        $widget = Tuzhi::make(
            get_called_class(),
            [$config]
        );
        Widget::$stack[] = $widget;

        return $widget;
    }

    /**
     * @return mixed
     * @throws InvalidParamException
     */
    public static function end()
    {
        $widget = array_pop( Widget::$stack );
        if( get_class($widget) == get_called_class() ){
            return $widget->run();
            //return $widget;
        }else{
            throw new InvalidParamException('Not found Widget '.get_called_class().' ');
        }
    }

    /**
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public static function widget( $config = [] )
    {
        ob_start();
        ob_implicit_flush(false);
        try {
            $widget = Tuzhi::make(get_called_class(), [$config]);
            $out =  $widget->run();
        }catch(\Exception $e){
            while( ob_get_level() > 0 ){
                ob_get_clean();
            }
            throw $e;
        }
        return ob_get_clean() . $out ;
    }

    /**
     *
     * @return mixed
     */
    abstract public function run();
}