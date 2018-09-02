<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/29
 * Time: 14:39
 */


class Response
{
    /**
     * @param $data
     * @param array $header
     * @return mixed
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public static function json( $data ,$header = [] )
    {
        $service = Tuzhi::App()->get('response');

        return Tuzhi::make(
            [
                'class' => $service->getResponseClass('json'),
                'response' => $service,
                'content' => $data
            ]
        );
    }

    /**
     * @param $resource
     * @param array $header
     * @return mixed
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public static function to( $resource ,$header =[] )
    {
        $service = Tuzhi::App()->get('response');

        return Tuzhi::make(
            [
                'class' => $service->getResponseClass('redirect'),
                'response' => $service,
                'content' => $resource
            ]
        );
    }

    /**
     * @return mixed
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public static function Referer(){
        return static::to($_SERVER['HTTP_REFERER']);
    }


    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundMethodException
     */
    public static function __callStatic($name, $arguments)
    {
        $Server = Tuzhi::App()->get('response');
        if( method_exists( $Server,$name ) ){
            return call_user_func_array([$Server,$name],$arguments);
        }
        throw new \tuzhi\base\exception\NotFoundMethodException('Not Found Method In Request, method is '.$name.'!');
    }


}