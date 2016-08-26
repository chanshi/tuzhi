<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 14:38
 */

namespace tuzhi\db\schema;


class ColumnSchema
{
    /**
     * @var 字段名
     */
    public $column;

    /**
     * @var 字段类型
     */
    public $type;

    /**
     * @var 字段长度
     */
    public $size;

    /**
     * @var
     */
    public $unsigned;

    /**
     * @var 是否允许为空
     */
    public $allowNull;

    /**
     * @var 默认值
     */
    public $defaultValue;

    /**
     * @var 允许的值 enum / set
     */
    public $allowValue;

    /**
     * @var 是否是主键
     */
    public $isPrimary = false;

    /**
     * @var bool 是否唯一
     */
    public $isUnique = false;

    /**
     * @var bool 是否自增
     */
    public $autoIncrement = false;

    /**
     * @var null 注解
     */
    public $comment = null;

}