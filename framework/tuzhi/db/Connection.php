<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:29
 */

namespace tuzhi\db;


use Exception;
use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\Object;
use tuzhi\support\loadBalance\LoadBalance;

class Connection extends Object
{

    /**
     * @var pdo Instance
     */
    protected $pdo;

    /**
     * @var string pdoClass
     */
    protected $pdoClass = 'PDO' ;

    /**
     * @var array pdo Attribute
     */
    protected $attribute = [];

    /**
     * @var string
     */
    protected $commandClass = 'tuzhi\db\Command';

    /**
     * @var
     */
    public $dsn;


    /**
     * @var  主服务器 只写
     */
    public $master;

    /**
     * @var  从服务器  只读
     */
    public $slave;

    /**
     *
     */
    public function init()
    {
        if( $this->master ){
            $this->master = $this->initServer($this->master);
        }
        if( $this->slave ){
            $this->slave  = $this->initServer($this->slave);
        }
    }

    /**
     * 有问题
     *
     * @param $group
     * @return mixed|null|Dsn
     * @throws InvalidParamException
     */
    public function initServer( $group )
    {
        $result = null;
        if( is_string($group) ){
            $result = new Dsn( $group );
        }else if(is_array( $group ) ){

            $config = [];

            if( ! isset($group['class'])){
                $config['class'] = '';
                $config['server'] = $group;
            }else{
                $config = $group;
            }

            $result = \Tuzhi::make($config);
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function isActivity()
    {
        return  ( $this->pdo instanceOf $this->pdoClass )
            ? true
            : false;
    }

    public function getTransaction()
    {

    }

    /**
     * @return pdo
     * @throws Exception
     * @throws InvalidParamException
     */
    public function open()
    {
        if( $this->isActivity() ){
            return $this->pdo;
        }

        $this->pdo = $this->getMaster();

        return $this->pdo;
    }

    /**
     * @param $dsn
     * @return mixed
     * @throws Exception
     * @throws InvalidParamException
     */
    public function createPdoInstance( $dsn )
    {
        if( $dsn instanceof $this->pdoClass ){
            return $dsn;
        }

        if( $dsn instanceof Dsn) {

            try{

                $pdoInstance = new $this->pdoClass($dsn,$dsn->getUserName() ,$dsn->getPassword() ,$this->attribute);

                $pdoInstance = $this->initConnection($pdoInstance);

            }catch(\PDOException $e){
                throw new Exception( $e->getMessage() , $e->errorInfo, (int) $e->getCode(), $e );
            }
            return $pdoInstance;
        }
        throw new InvalidParamException('Invalid Param Dsn In Connection '.$dsn.' ' );
    }

    /**
     * @param $pdoClass
     * @return mixed
     */
    public function initConnection( $pdoClass )
    {
        return $pdoClass;
    }

    public function close()
    {
        //Close All;
        if( $this->isActivity() ){
            $this->pdo->close();

        }
        //Clean Value;
        $this->pdo = null;

    }

    /**
     * @return mixed|null|Dsn|主服务器
     * @throws Exception
     * @throws InvalidParamException
     */
    public function getMaster()
    {
        return $this->choosePdo( $this->master );
    }

    /**
     * @return mixed
     * @throws InvalidParamException
     */
    public function getSlave()
    {
        if( empty($this->slave) ){
            return $this->getMaster();
        }
        return $this->choosePdo( $this->slave );
    }

    /**
     * @param $obj
     * @return mixed
     * @throws Exception
     * @throws InvalidParamException
     */
    protected function choosePdo( &$obj )
    {
        if( is_string($obj) ){
            
        }

        if( is_array($obj) ){
            $obj = new Dsn($obj) ;
            return $this->choosePdo( $obj );
        }

        if( $obj instanceof $this->pdoClass){
            return $obj;
        }

        if( $obj instanceof Dsn){
            $obj = $this->createPdoInstance($obj);
            return $obj;
        }

        if( $obj instanceof LoadBalance){
            $server = $obj->loop();
            $instance = $server->getServer();
            $instance = $this->choosePdo($instance);
            $server->updateServer( $instance );
            return $instance;
        }
        throw new InvalidParamException( 'Invalid Param '.$obj.' type not the PdoClass ,Dsn or LoadBalance ' );
    }


    public function createCommand( $sql = null , $param = [] )
    {
        $command = new $this->commandClass([
            'db' =>$this,
            'sql'=> $sql
        ]);

        return $command->bindValues( $param );
    }

    public function getSchema()
    {

    }



}