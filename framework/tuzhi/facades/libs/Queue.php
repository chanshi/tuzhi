<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/16
 * Time: 15:02
 */

/**
 * Class Queue
 */
class Queue
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \tuzhi\base\exception\NotFoundMethodException
     */
    public static function __callStatic($name, $arguments)
    {
        $Server = Tuzhi::App()->get('queue');

        if( ! ( $queue = $Server->get( $name ) ) ){
            throw new \tuzhi\base\exception\NotFoundMethodException('Not Found Queue  '.$name.'!');
        }
        return $queue;
    }
}