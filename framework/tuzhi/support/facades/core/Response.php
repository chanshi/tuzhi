<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/29
 * Time: 14:39
 */


class Response extends \tuzhi\support\facades\Facades
{
    /**
     * @var string
     */
    protected static $serviceName ='response';

    /**
     * @param $data
     * @param array $header
     * @return mixed
     */
    public static function json( $data ,$header = [] )
    {
        static::init();

        return Tuzhi::make(
            [
                'class' => static::$service->getResponseClass('json'),
                'response' => static::$service,
                'content' => $data
            ]
        );
    }


}