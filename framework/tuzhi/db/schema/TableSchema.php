<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 14:37
 */

namespace tuzhi\db\schema;

class TableSchema
{

    protected $columnSchema = 'tuzhi\db\schema\ColumnSchema';
    /**
     * @var 表名
     */
    public $name;

    /**
     * @var 字段
     */
    public $columns = [];

    /**
     * @var array 主键
     */
    public $primaryKey = [];

    /**
     * @var array 外键
     */
    public $foreignKey = [];



    /**
     * @return array
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getAllColumns()
    {
        return array_keys($this->columns);
    }

    public function getNewColumn()
    {
        return  new $this->columnSchema();
    }

    public function getColumn($column)
    {
        if(isset( $this->columns[$column] ) ){
            return $this->columns[$column];
        }else{
            return null;
        }
    }

}