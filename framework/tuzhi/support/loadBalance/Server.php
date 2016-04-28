<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 17:46
 */

namespace tuzhi\support\loadBalance;


use tuzhi\base\Object;
use tuzhi\contracts\support\loadBalance\IServer;

class Server extends Object implements IServer
{

    /**
     * @var
     */
    public $id;

    /**
     * @var array
     */
    public $serverInstance;

    /**
     * @var null
     */
    public $hashId = null;

    /**
     * @var int
     */
    public $weight = 100;

    /**
     * Server constructor.
     * @param array $server
     * @param array $config
     */
    public function __construct( $server ,$config=[])
    {
        $this->serverInstance = $server;
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function getServer()
    {
        return $this->serverInstance;
    }

    /**
     * @param $server
     * @return $this
     */
    public function setServer($server )
    {
        $this->serverInstance = $server;

        return $this;
    }

    /**
     * @return null
     */
    public function getHashId()
    {
        if( $this->hashId == null ){
            $this->hashId = sha1(serialize( $this->serverInstance ) );
        }
        return $this->hashId;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }
}