<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:36
 */

namespace tuzhi\db;

use tuzhi\base\Event;
use tuzhi\base\Object;
use tuzhi\support\profiler\Timer;

/**
 * Class Command
 * @package tuzhi\db
 */
class Command extends Object
{
    /**
     *
     */
    const EVENT_BEFORE_EXECUTE = 'event.command.before.execute';

    /**
     *
     */
    const EVENT_AFTER_EXECUTE = 'event.command.after.execute';

    const EVENT_BEFORE_QUERY  = 'event.command.before.query';

    const EVENT_AFTER_QUERY   = 'event.command.after.query';
    /**
     * @var
     */
    public $db;

    /**
     * @var
     */
    public $sql;

    /**
     * @var
     */
    public $raw;

    /**
     * @var int
     */
    public $fetchMode = \PDO::FETCH_ASSOC ;

    /**
     * @var array
     */
    protected $param = [];

    /**
     * @var array
     */
    protected $pendingParam = [];

    /**
     * @var
     */
    protected $statement;



    /**
     * @return mixed
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @param $sql
     * @return $this
     */
    public function setSql( $sql )
    {
        if( $sql != $this->sql ){
            $this->sql = $sql;
            $this->statement = null;
            $this->param = [];
            $this->pendingParam = [];
        }
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @param $type
     * @throws \Exception
     */
    public function bindParam( $name ,$value ,$type )
    {
        $this->prepare();
        $this->statement->bindValue( $name ,$value ,$type );
    }

    /**
     * @return $this
     */
    public function bindPendingParam()
    {
        if( empty( $this->pendingParam ) ){
            return $this;
        }

        foreach( $this->pendingParam as $name=>$value )
        {
            $this->statement->bindValue( $name ,$value[0] ,$value[1] );
        }
        $this->pendingParam = [];
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function bindValue( $name ,$value )
    {
        $type = $this->db->getSchema()->getPdoType( $value );
        $this->pendingParam[$name] = [$value ,$type];
        $this->param[$name] = $value;
        return $this;
    }

    /**
     * @param array $param
     * @return $this
     */
    public function bindValues( $param = [] )
    {
        if( empty( $param ) ){
            return $this;
        }

        foreach( $param as $name=>$value ){
           $this->bindValue($name,$value);
        }

        return $this;
    }

    /**
     * @param bool $isRead
     * @return mixed
     * @throws \Exception
     */
    public function prepare( $isRead = false )
    {
        if( $this->statement ){
            return $this->statement;
        }

        $sql = $this->getSql();
        try{
            //TODO:: 注意 事务处理 必须使用 Master PDO;
            if( $this->db->transactionActivity() ){
                $pdo = $this->db->pdo;
            }else{
                //TODO:: 检查SQL 是否是查询
                if( $this->db->isQuerySql( $sql ) ){
                    $isRead = true;
                }

                $pdo = ! $isRead
                    ? $this->db->getMaster()
                    : $this->db->getSlave();
            }

            $this->statement = $pdo->prepare( $sql );

            //TODO:: 绑定参数
            $this->bindPendingParam();

        }catch(\PDOException $e){
            //TODO::异常混乱
            //$message = $e->getMessage() . "\nFailed to prepare SQL: $sql";
            //$errorInfo = $e instanceof \PDOException ? $e->errorInfo : null;
            //throw new ErrorException($message,$e->getCode(),$e->getCode(),$e);
            throw $e;
        }

    }

    /**
     * execute  Install  Delete  Update
     */
    public function execute()
    {
        $sql = $this->getSql();

        if( empty($sql) ){
            return 0;
        }

        $this->prepare(FALSE);

        try{

            Event::trigger(Command::className(),Command::EVENT_BEFORE_EXECUTE);

            Timer::mark('tuzhi.command.execute.start');

            $this->statement->execute();

            $num = $this->statement->rowCount();

            Timer::mark('tuzhi.command.execute.end');

            Event::trigger(
                Command::className(),
                Command::EVENT_AFTER_EXECUTE,
                [Timer::slice('tuzhi.command.execute'),$sql]
            );

            return $num;

        }catch( \Exception $e ){
            //异常问题
            //$message = $e->getMessage() . "\nFailed to execute SQL: $sql";
            //$errorInfo = $e instanceof \PDOException ? $e->errorInfo : null;
            //throw new \Exception($message, $errorInfo, (int) $e->getCode(), $e);
            throw $e;
        }

    }

    /**
     * @param null $method
     * @param int $fetchMode
     * @return int
     * @throws \Exception
     */
    protected function queryInterval( $method = null ,$fetchMode = \PDO::FETCH_ASSOC )
    {
        $sql = $this->getSql();

        if( empty($sql) ){
            return 0;
        }

        $this->prepare(TRUE);

        try{

            Event::trigger(Command::className(),Command::EVENT_BEFORE_QUERY);

            Timer::mark('tuzhi.command.query.start');

            $this->statement->execute();

            if( $fetchMode === null ){
                $fetchMode = $this->fetchMode;
            }

            if( $method == null ){
                //TODO:: 提交给DataRead;
            }else{
                $result  = call_user_func_array([$this->statement ,$method] ,[$fetchMode]);
            }
            //关闭
            $this->statement->closeCursor();

            Timer::mark('tuzhi.command.query.end');

            Event::trigger(
                Command::className(),
                Command::EVENT_AFTER_QUERY,
                [Timer::slice('tuzhi.command.query'),$sql]);

        } catch ( \PDOException $e ){
            $message = $e->getMessage() . "\nFailed to query SQL: $sql";
            //$errorInfo = $e instanceof \PDOException ? $e->errorInfo : null;
            //throw new \Exception($message, $errorInfo, (int) $e->getCode(), $e);
            throw $e;
        }

        return $result;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function query()
    {
        return $this->queryInterval('fetchAll');
    }

    /**
     * @param null $fetchMode
     * @return int
     * @throws \Exception
     */
    public function queryAll( $fetchMode = null)
    {
        return $this->queryInterval('fetchAll',$fetchMode);
    }

    /**
     * @param null $fetchMode
     * @return int
     * @throws \Exception
     */
    public function queryOne($fetchMode = null)
    {
        return $this->queryInterval('fetch' ,$fetchMode);
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function queryColumn()
    {
        return $this->queryInterval('fetchColumn',\PDO::FETCH_COLUMN);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function queryScalar()
    {
        $result = $this->queryInterval('fetchColumn',0);
        return $result;
    }

}