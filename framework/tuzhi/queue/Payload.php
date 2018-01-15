<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/14
 * Time: 14:45
 */

namespace tuzhi\queue;


use tuzhi\helper\Str;
use tuzhi\model\ArrayData;

/**
 * Class Payload
 * @package tuzhi\queue
 */
class Payload extends ArrayData
{
    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();
        $this['id'] = $this->createId();
        $this['attempts'] = 0;
        $this['time'] = time();
    }

    /**
     * @return string
     */
    protected function createId()
    {
        return date('YmdHis').'#'.Str::random(10);
    }

    /**
     * @return string
     */
    public function toEncode()
    {
        return static::encode($this);
    }
    /**
     * @param $Payload
     * @return string
     */
    public static function encode( $Payload )
    {
        return serialize($Payload);
    }

    /**
     * @param $Payload
     * @return mixed
     */
    public static function decode( $Payload )
    {
        return unserialize($Payload);
    }
}