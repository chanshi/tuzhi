<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 14:37
 */

namespace tuzhi\db\schema;

/**
 * Class TableSchema
 * @package tuzhi\db\schema
 */
class TableSchema
{

    protected $columnSchema = 'tuzhi\db\schema\ColumnSchema';
    /**
     * @var
     */
    public $name;

    /**
     * @var array
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
    public function primary()
    {
        return $this->primaryKey;
    }

    /**
     * 获取所有的字段
     * @return array
     */
    public function columns()
    {
        return array_keys($this->columns);
    }

    /**
     * @return mixed
     */
    public function getNewColumn()
    {
        return  new $this->columnSchema();
    }

    /**
     * @param $column
     * @return null
     */
    public function getColumn($column)
    {
        return isset($this->columns[$column])
            ? $column
            : null;
    }

}