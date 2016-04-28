<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:36
 */

namespace tuzhi\db;

use tuzhi\base\Object;

class Command extends Object
{
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


    public $fetchMode = \PDO::FETCH_ASSOC ;

    protected $param = [];

    protected $pendingParam = [];

    protected $statement;



    /**
     * Command constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

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



    public function prepare( $isRead = false )
    {
        if( $this->statement ){
            return $this->statement;
        }

        $sql = $this->getSql();
        try{
            //TODO:: 注意 事务处理 必须使用 Master PDO;
            if( $this->db->getTransaction() ){
                $isRead = false;
            }
            //TODO:: 检查SQL 是否是查询

            $pdo = $isRead
                ? $this->db->getMaster()
                : $this->db->getSlave();

            $this->statement = $pdo->prepare( $sql );

            //TODO:: 绑定参数
            $this->bindPendingParam();

        }catch(\Exception $e){
            //TODO::
            $message = $e->getMessage() . "\nFailed to prepare SQL: $sql";
            $errorInfo = $e instanceof \PDOException ? $e->errorInfo : null;
            throw new \Exception($message, $errorInfo, (int) $e->getCode(), $e);
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

            $this->statement->execute();

            $num = $this->statement->rowCount();

            return $num;

        }catch( \Exception $e ){
            $message = $e->getMessage() . "\nFailed to execute SQL: $sql";
            $errorInfo = $e instanceof \PDOException ? $e->errorInfo : null;
            throw new \Exception($message, $errorInfo, (int) $e->getCode(), $e);
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

            $this->statement->execute();

            if( $fetchMode == null ){
                $fetchMode = $this->fetchMode;
            }

            if( $method == null ){
                //TODO:: 提交给DataRead;
            }else{
                $result  = call_user_func_array([$this->statement ,$method] ,[$fetchMode]);
            }
            $this->statement->closeCursor();

            return $result;

        } catch ( \Exception $e ){
            $message = $e->getMessage() . "\nFailed to query SQL: $sql";
            $errorInfo = $e instanceof \PDOException ? $e->errorInfo : null;
            throw new \Exception($message, $errorInfo, (int) $e->getCode(), $e);
        }
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function query()
    {
        return $this->queryInterval('fetch');
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
}