<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/3/27
 * Time: 11:46
 */

namespace tuzhi\base;


use tuzhi\contracts\base\IObject;

/**
 * Class Object
 * @package tuzhi\base
 */
class Object implements IObject
{

    /**
     * @param array $config
     */
    public function __configure(array $config = [])
    {
        if(!empty( $config )){
            \Tuzhi::config($this,$config);
        }
        $this->init();
    }

    public function __construct(array $config = []  )
    {
        return $this->__configure($config);
    }

    /**
     * @return mixed
     */
    public static function getClassName()
    {
        return get_class( __CLASS__ );
    }


    public function init() {}
}