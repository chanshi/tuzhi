<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 09:25
 */

namespace tuzhi\web\cookie;


class Cookie {

    /**
     * @var
     */
    public $name;

    /**
     * @var null
     */
    public $value;

    /**
     * @var
     */
    public $expire;

    /**
     * @var string
     */
    public $path;

    /**
     * @var
     */
    public $domain;

    /**
     * @var bool
     */
    public $secure;

    /**
     * @var bool
     */
    public $httpOnly;


    /**
     * Cookie constructor.
     * @param $name
     * @param null $value
     * @param int $expire
     * @param string $path
     * @param string $domain
     * @param bool $secure
     * @param bool $httpOnly
     */
    public function __construct($name , $value = null ,$expire = 0 ,$path = '/' ,$domain = '' ,$secure = true ,$httpOnly = true)
    {
        $this->name = $name;
        $this->value = $value;
        $this->expire = time() + $expire;
        $this->path = $path;
        $this->domian =  empty($domain) ? \Tuzhi::$app->request->getDomain() : $domain ;
        $this->secure = (boolean) $secure;
        $this->httpOnly = (boolean) $httpOnly;
    }
}