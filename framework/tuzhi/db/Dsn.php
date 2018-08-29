<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 14:56
 */

namespace tuzhi\db;

use tuzhi\base\BObject;

class Dsn extends BObject
{
    /**
     * @var
     */
    public $driver;

    /**
     * @var
     */
    public $host = 'localhost';

    /**
     * @var int
     */
    public $port = 3306;

    /**
     * @var
     */
    public $schema;

    /**
     * @var string
     */
    public $charset = 'UTF8';

    /**
     * @var
     */
    public $userName;

    /**
     * @var
     */
    public $password;

    /**
     * @var
     */
    public $dsn;

    /**
     *
     */
    public function init()
    {
        //存在 加密 解密的问题
        // 从DSN  翻译
        //TODO:: dsn  解析
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getDsn();
    }

    /**
     * @return string
     */
    public function getDsn()
    {
        if( $this->dsn == null ){
            $this->dsn = $this->driver .
                ':host='   . $this->host .
                ';port='   . $this->port .
                ';dbname=' . $this->schema .
                ';charset='. $this->charset;
        }
        return $this->dsn;
    }

}