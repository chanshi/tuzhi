<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/4
 * Time: 21:18
 */

use tuzhi\base\exception\NotFoundMethodException;

class View extends \tuzhi\support\facades\Facades
{
    protected static $serviceName = 'view';

    /**
     * @var
     */
    protected static $service;

    /**
     * @var bool
     */
    protected static $isInit = false;
    /**
     * @param $view
     * @param array $__params__
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundMethodException
     */
    public static function layout( $view ,$__params__ = [] )
    {
        static::init();
        if( static::$service ){
            return static::$service->renderPage( $view ,$__params__ );
        }
        throw new NotFoundMethodException('Not Found Server View');
    }

    public static function fetch($view ,$__params__ = []){
        static::init();
        if( static::$service ){
            return static::$service->render( $view ,$__params__ );
        }
        throw new NotFoundMethodException('Not Found Server View');
    }
}