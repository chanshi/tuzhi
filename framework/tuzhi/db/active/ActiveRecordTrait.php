<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/7
 * Time: 18:17
 */

namespace tuzhi\db\active;


use tuzhi\db\query\DeleteQuery;
use tuzhi\db\query\InsertQuery;
use tuzhi\db\query\Query;
use tuzhi\db\query\UpdateQuery;

trait ActiveRecordTrait
{
    /**
     * @return mixed
     */
    public static function tableName()
    {
        return strtolower( basename( str_replace('\\','//',get_called_class())) );
    }

    /**
     * @return $this
     */
    public static function find()
    {
        $query = new Query();
        return $query->table( static::tableName() );
    }

    /**
     * 简单粗暴
     * @param $data
     * @return mixed
     */
    public static function insert( $data )
    {
        return (new InsertQuery(static::tableName(),$data))
            ->insert();
    }

    /**
     * 返回
     * @param $data
     * @return UpdateQuery
     */
    public static function update( $data = null )
    {
        return (new UpdateQuery(static::tableName(),$data));
    }

    /**
     * @return DeleteQuery
     */
    public static function delete()
    {
        return (new DeleteQuery(static::tableName()));
    }

    /**
     * @param $primary
     * @return static
     */
    public static function getRecord( $primary )
    {
        return new static( $primary );
    }

}