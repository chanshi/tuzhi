<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 14:56
 */

namespace tuzhi\db;

use tuzhi\base\Object;

class Dsn extends Object
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
     * Dsn constructor.
     * @param array $config
     */
    public function __construct( $config )
    {
        if(is_string($config)){

            //从配置中读取 @

        }

        parent::__construct($config);
        
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
     * @return string
     */
    public function __toString()
    {
        return $this->driver .
            ':host='   . $this->host .
            ';port='   . $this->port .
            ';dbname=' . $this->schema .
            ';charset='. $this->charset;
    }

}