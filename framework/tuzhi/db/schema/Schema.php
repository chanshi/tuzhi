<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:39
 */

namespace tuzhi\db\schema;


use tuzhi\base\Object;
use tuzhi\cache\Cache;
use tuzhi\db\query\Expression;
use tuzhi\db\query\QueryBuilder;

class Schema extends Object
{

    /**
     * @var
     */
    public $db;

    /**
     * @var
     */
    public $builder;

    /**
     * @var
     */
    protected $cache;

    /**
     * @var string
     */
    protected $tableSchemaClass = 'tuzhi\db\schema\TableSchema';


    /**
     *
     */
    public function init()
    {
        //TODO:: CACHE
       // $this->cache = Cache::$cache;
    }

    
    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        if( $this->builder == null ){
            $this->builder = new QueryBuilder();
        }
        return $this->builder;
    }

    /**
     * @param $data
     * @return int|mixed
     * @see Yii2
     */
    public function getPdoType( $data )
    {
        static $typeMap = [
            // php type => PDO type
            'boolean' => \PDO::PARAM_BOOL,
            'integer' => \PDO::PARAM_INT,
            'string' => \PDO::PARAM_STR,
            'resource' => \PDO::PARAM_LOB,
            'NULL' => \PDO::PARAM_NULL,
        ];
        $type = gettype($data);

        return isset($typeMap[$type]) ? $typeMap[$type] : \PDO::PARAM_STR;
    }


    public function getLastInsertId($colums =null )
    {
        return $this->db->getMasterPdo()->lastInsertId($colums);
    }

    /**
     * @param $value
     * @return string
     * @see yii2
     */
    public function quoteValue( $value )
    {
        if( !is_string($value) ){
            return $value;
        }
        //todo::  性能问题  
        //if( ($value = $this->db->getSlave()->quote($value)) !== false ){
        //    return $value;
        //}else{
            return "'" . addcslashes(str_replace("'", "''", $value), "\000\n\r\\\032") . "'";
        //}
    }

    /**
     * @param $table
     * @return string
     */
    public function quoteTableName( $table )
    {
        if(is_string($table) && strpos($table,'.') ){
            $tables =[];
            foreach(explode('.',$table)  as $t){
                $tables[] = $this->quoteSimpleTable($t);
            }
            return join('.',$tables);
        }

        return $this->quoteSimpleTable( $table );
    }

    /**
     * @param $table
     * @return string
     */
    public function quoteSimpleTable($table)
    {
        return strpos($table,'`') !== false
            ? $table
            : "`$table`";
    }

    /**
     * @param $column
     * @return mixed|string
     */
    public function quoteColumn( $column )
    {
        if($column == '*') {
            return $column;
        }
        if( $column instanceof Expression ){
            return $column->getValue();
        }

        if( is_string($column) && strpos($column,'.') ){
            $cols = [];
            foreach( explode('.',$column) as $col ){
                $cols[] = $this->quoteSimpleColumn( $col );
            }
            return join('.',$cols);
        }

        return $this->quoteSimpleColumn( $column );
    }

    /**
     * @param $column
     * @return string
     */
    public function quoteSimpleColumn( $column )
    {
        return strpos($column ,'`') !== false
            ? $column
            : "`$column`";
    }

    /**
     * @param $pointName
     * @return mixed
     */
    public function createSavePoint( $pointName )
    {
        return $this->db->createCommand("SAVEPOINT $pointName;")
            ->execute();
    }

    /**
     * @param $pointName
     * @return mixed
     */
    public function releaseSavePoint( $pointName )
    {
        return $this->db->createCommand("RELEASE SAVEPOINT $pointName;")
            ->execute();
    }

    /**
     * @param $pointName
     * @return mixed
     */
    public function rollBackSavePoint( $pointName )
    {
        return $this->db->createCommand("ROLLBACK TO SAVEPOINT $pointName;")
            ->execute();
    }

    /**
     * @param $level
     * @return mixed
     */
    public function setTransactionLevel( $level )
    {
        return $this->db->createCommand("SET TRANSACTION ISOLATION LEVEL $level;")
            ->execute();
    }
}