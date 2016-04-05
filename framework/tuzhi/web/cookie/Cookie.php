<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 09:25
 */

namespace tuzhi\web\cookie;


class Cookie {

    public $name;

    public $value;

    public $expire;

    public $path;

    public $domain;

    public $secure;

    public $httponly;

    /**
     * Cookie constructor.
     * @param $name
     * @param null $value
     * @param int $expire
     * @param string $path
     * @param $domain
     * @param bool $secure
     * @param bool $httponly
     */
    public function __construct($name , $value = null ,$expire = 0 ,$path = '/' ,$domain = '' ,$secure = true ,$httponly = true)
    {
        $this->name = $name;
        $this->value = $value;
        $this->expire = time() + $expire;
        $this->path = $path;
        $this->domian =  empty($domain) ? \Tuzhi::$app->request->getDomain() : $domain ;
        $this->secure = $secure;
        $this->httponly = $httponly;
    }
}