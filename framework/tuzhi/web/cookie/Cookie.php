<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 09:25
 */

namespace tuzhi\web\cookie;


use tuzhi\base\Object;

/**
 * Class Cookie
 * @package tuzhi\web\cookie
 */
class Cookie extends Object{

    /**
     * @var
     */
    public $name;

    /**
     * @var null
     */
    public $value = '';

    /**
     * @var
     */
    public $expire = 0;

    /**
     * @var string
     */
    public $path = '/';

    /**
     * @var
     */
    public $domain = '';

    /**
     * @var bool
     */
    public $secure = false;

    /**
     * @var bool
     */
    public $httpOnly = true;

    /**
     *
     */
    public function init()
    {
        /**
         * default ?
         */
        $this->expire = $this->expire
            ?  (int) $this->expire + time()
            : 0;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return  (string) $this->value;
    }

}