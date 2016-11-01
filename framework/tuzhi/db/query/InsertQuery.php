<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/7
 * Time: 22:49
 */

namespace tuzhi\db\query;

/**
 *
 *  (new InsertQuery( table ))->insert( data );
 *
 * Class InsertQuery
 * @package tuzhi\db\query
 */
class InsertQuery  extends Query
{

    /**
     * @var null
     */
    public $params;

    /**
     * InsertQuery constructor.
     * @param null $table
     * @param null $params
     * @param array $config
     */
    public function __construct($table = null ,$params = null ,array $config = [])
    {
        parent::__construct($config);

        if($table !== null){
            $this->table($table);
        }
        if( $params !== null ){
            $this->params = $params;
        }
    }

    /**
     * @return mixed
     */
    public function getSqlString()
    {
        return $this->db->getQueryBuild()->buildInsert( $this );
    }

    /**
     * @param null $params
     * @return mixed
     */
    public function insert( $params = null )
    {
        if( $params ){
            $this->params = $params;
        }
        $sql = $this->getSqlString();

        //TODO:: 是否加事务
        $this->db->createCommand( $sql )->execute();
        return $this->db->getSchema()->getLastInsertId();
    }
}