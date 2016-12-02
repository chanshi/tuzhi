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
use tuzhi\base\Server;
use tuzhi\cache\Cache;
use tuzhi\db\query\QueryBuilder;
use tuzhi\helper\Arr;
use tuzhi\support\loadBalance\LoadBalance;
use tuzhi\support\profiler\Counter;
use tuzhi\support\profiler\Timer;

/**
 * Class Connection
 * @package tuzhi\db
 */
class Connection extends Server
{

    /**
     * @var pdo Instance
     */
    public $pdo;

    /**
     * @var string pdoClass
     */
    protected $pdoClass = 'PDO' ;

    /**
     * @var array pdo Attribute
     */
    public $attribute = [ \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

    /**
     * @var string
     */
    protected $commandClass = 'tuzhi\db\Command';

    /**
     * @var array
     */
    protected static $schemaMap =
        [
            'mysql' => 'tuzhi\db\engine\mysql\Schema'
        ];

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
    private $driverName;

    /**
     * @var
     */
    private $schema;

    /**
     * @var  主服务器  可写  可读
     */
    public $master;

    /**
     * @var  从服务器  只读
     */
    public $slave;

    /**
     * @var Cache
     */
    public $cache = 'cache';

    /**
     * @var string
     */
    public $dbHashName;

    /**
     * @var
     */
    public $databaseName;

    /**
     * @var Transaction
     */
    protected  $transaction;



    /**
     * 初始化
     */
    public function init()
    {
        $this->cache = \Tuzhi::App()->get($this->cache);

        $this->dbHashName =  md5( serialize($this->master) );

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

    /**
     * @return bool
     */
    public function transactionActivity()
    {
        $status = false;
        if( $this->transaction instanceof Transaction && $this->transaction->getLevel() ){
            $status = true;
        }
        return $status;
    }

    /**
     * @return Transaction
     */
    public function beginTransaction()
    {
        $transaction = new Transaction(['db'=>$this]);
        return $this->transaction  = $transaction;
    }

    /**
     * @return bool
     */
    public function getTransaction()
    {
        if( $this->transaction == null ){
            $this->beginTransaction();
        }
        return $this->transaction;
    }

    /**
     * @param callable $callback
     * @return mixed
     * @throws Exception
     */
    public function transaction( callable $callback )
    {
        $transaction = $this->getTransaction();
        $transaction->begin();
        $level = $transaction->getLevel();

        try{
            $result = call_user_func($callback ,$this);

            if( $transaction->getLevel() == $level){
                $transaction->commit();
            }
        }catch(Exception $e){
            if( $transaction->getLevel() == $level){
                $transaction->rollback();
            }
            throw $e;
        }
        return $result;
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

                Timer::mark('tuzhi.db.connection.start');
                $pdoInstance = new $this->pdoClass($dsn->getDsn(),$dsn->getUserName() ,$dsn->getPassword() );

                $pdoInstance = $this->initConnection($pdoInstance);
                Timer::mark('tuzhi.db.connection.end');
                Counter::increment('tuzhi.db.connection');
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
    protected function initConnection( $pdoClass )
    {
        $pdoClass->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        //TODO:: SET NAMES
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

    public function getMasterPdo()
    {
        return $this->getMaster();
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


    /**
     * @param null $sql
     * @param array $param
     * @return mixed
     */
    public function createCommand( $sql = null , $param = [] )
    {
        $command = new $this->commandClass([
            'db' =>$this,
            'sql'=> $sql
        ]);

        return $command->bindValues( $param );
    }

    /**
     * @return mixed
     * @throws InvalidParamException
     */
    public function getSchema()
    {
        if($this->schema == null ){
            $this->schema = \Tuzhi::make(
                [
                    'class' => static::$schemaMap[ $this->getDriverName() ],
                    'db' => $this
                ]);
        }
        return $this->schema;
    }

    /**
     * @param $table
     * @return mixed
     */
    public function getTableSchema( $table )
    {
        return $this->getSchema()->getTableSchema( $table );
    }


    /**
     * @return QueryBuilder  简单处理
     */
    public function getQueryBuild()
    {
        return new QueryBuilder(['db'=>$this]);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function quoteValue( $value )
    {
        return $this->getSchema()
            ->quoteValue( $value );
    }

    /**
     * @param $table
     * @return mixed
     */
    public function quoteTable( $table )
    {
        return $this->getSchema()
            ->quoteTableName( $table );
    }

    /**
     * @param $column
     * @return mixed
     */
    public function quoteColumn( $column )
    {
        return $this->getSchema()
            ->quoteColumn( $column );
    }

    /**
     * @return mixed
     */
    public function getDriverName()
    {
        if($this->driverName == null){
            $this->driverName = strtolower( $this->getMaster()->getAttribute( \PDO::ATTR_DRIVER_NAME ) );
        }
        return $this->driverName;
    }

    /**
     * @return mixed
     */
    public function getDatabaseName()
    {
        if( $this->databaseName == null ){
            //TODO:: 注意这里有一个BUG 返回的对象 可能无法获取
            if( $this->master instanceof  Dsn) {
                $this->setDatabaseName( $this->master->getSchema() );
            }
            //TODO:: 这里还需要做处理
        }
        return $this->databaseName;
    }

    /**
     * @param $databaseName
     * @return $this
     */
    public function setDatabaseName( $databaseName )
    {
        if($this->databaseName == null){
            $this->databaseName = $databaseName;
        }
        return $this;
    }


    /**
     *
     * @param $sql
     * @return mixed
     */
    public function isQuerySql( $sql )
    {
        $pattern = '/^\s*(SELECT|SHOW|DESCRIBE)\b/i';
        return preg_match($pattern, $sql) > 0;
    }

}