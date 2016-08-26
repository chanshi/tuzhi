<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/4
 * Time: 21:18
 */

class View extends \tuzhi\support\facades\Facades
{
    protected static $serviceName = 'view';


    /**
     * @param $view
     * @param array $__params__
     * @return mixed
     */
    public static function layout( $view ,$__params__ = [] )
    {
        static::init();
        if( static::$service ){
            return static::$service->renderPage( $view ,$__params__ );
        }
        //throw new \tuzhi\base\exception\NotFoundMethodException('a');

    }
}