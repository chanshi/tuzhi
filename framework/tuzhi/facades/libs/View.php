<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/4
 * Time: 21:18
 */


class View
{

    /**
     * @param $view
     * @param array $__params__
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundServersException
     */
    public static function layout( $view ,$__params__ = [] )
    {
        $service = Tuzhi::App()->get('view');
        if($service ){
            return $service->renderPage( $view ,$__params__ );
        }
        throw new \tuzhi\base\exception\NotFoundServersException('Not Found Server View');
    }

    /**
     * @param $view
     * @param array $__params__
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundServersException
     */
    public static function fetch($view ,$__params__ = []){
        $service = Tuzhi::App()->get('view');
        if( $service ){
            return $service->render( $view ,$__params__ );
        }
        throw new \tuzhi\base\exception\NotFoundServersException('Not Found Server View');
    }
}