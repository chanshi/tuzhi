<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:29
 */

namespace tuzhi\db;


use Exception;
use tuzhi\base\ErrorException;
use tuzhi\base\exception\InvalidParamException;
use tuzhi\base\Object;
use tuzhi\base\Server;
use tuzhi\helper\Arr;
use tuzhi\support\loadBalance\LoadBalance;

class Connection extends Server
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
    public $attribute = [];

    /**
     * @var string
     */
    protected $commandClass = 'tuzhi\db\Command';

    /**
     * @var string
     */
    public $dispatchClass = 'tuzhi\support\loadBalance\LoadBalance';

    /**
     * @var string
     */
    public $dispatchMethod = 'round';

    /**
     * @var
     */
    public $dsn;

    /**
     * @var  主服务器  可写  可读
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
     *
     * @param $data
     * @return mixed|Dsn
     * @throws InvalidParamException
     */
    public function initServer( $data )
    {
        $result = null;
        // 直接调度
        if( $this->isDsnString($data) ){
            return new Dsn(['dsn'=>$data]);
        }
        // 检查是否是单独的配置
        if( is_array($data) &&  Arr::isAssoc($data) && Arr::has($data,['userName','schema']) )
        {
            return new Dsn($data);
        }
        // 检查是否需要调度处理
        if( is_array($data) && ( ! Arr::isAssoc($data)  ||  Arr::has($data,'server')  ) ){

            $config['class'] =$this->dispatchClass;
            if( Arr::has( $data ,'server' ) ){
                $config['server'] = $data['server'];
                $config['dispatch'] = isset( $data['dispatch'] ) ? $data['dispatch'] : $this->dispatchMethod;
            }else{
                $config['server']  = $data;
                $config['dispatch'] = $this->dispatchMethod;
            }

            return \Tuzhi::make($config);
        }
        throw new InvalidParamException('Invalid Param in db/Connection '.json_encode($data) );

    }

    /**
     * @param $string
     * @return bool
     */
    public function isDsnString( $string )
    {
        if( is_string($string) )
        {
            //TODO:: 简单的 DSN 匹配
            return preg_match('#^\w+\:[\w\d\.]+;#',$string) ? true : false;
        }
        return false;
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
        return false;
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

                $pdoInstance = new $this->pdoClass($dsn->getDsn(),$dsn->getUserName() ,$dsn->getPassword() ,$this->attribute);

                $pdoInstance = $this->initConnection($pdoInstance);

            }catch(\PDOException $e){
                //TODO:: 异常捕获 有问题
                throw $e;
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
        /**
         * 配置问题 OR DSN string?
         */
        if( is_string($obj) ){
            $config = \Tuzhi::config( $obj );
            return $this->choosePdo( $config );
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
            //重新设置
            $server->setServer( $instance );
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