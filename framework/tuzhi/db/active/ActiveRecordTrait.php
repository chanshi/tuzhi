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
use tuzhi\db\query\Expression;

trait ActiveRecordTrait
{

    public static function getDb()
    {
        return \Tuzhi::App()->get('db');
    }

    /**
     * @return mixed
     */
    public static function tableName()
    {
        return strtolower( basename( str_replace('\\','//',get_called_class())) );
    }

    /**
     * @return string
     */
    public static function fullTableName()
    {
        return static::getDb()->getDatabaseName().'.'.static::tableName();
    }

    /**
     * @param null $Columns
     * @return mixed
     */
    public static function find( $Columns = null )
    {
        $Query = (new Query( ['db'=> static::getDb() ] ))->table( static::tableName() );
        $Columns
            ? $Query->select($Columns)
            : null;
        return $Query;
    }

    /**
     * @return Query
     */
    public static function query()
    {
        return (new Query( ['db'=>static::getDb() ] ) );
    }

    /**
     * 简单粗暴
     * @param $data
     * @return mixed
     */
    public static function insert( $data = null)
    {
        return (new InsertQuery(static::tableName(), $data, ['db'=>static::getDb()] ))
            ->insert();
    }

    /**
     * @param null $data
     * @return UpdateQuery
     */
    public static function update( $data = null )
    {
        return (new UpdateQuery(static::tableName(), $data, ['db'=>static::getDb()] ));
    }

    /**
     * @return DeleteQuery
     */
    public static function delete()
    {
        return (new DeleteQuery(static::tableName(), ['db'=>static::getDb()] ));
    }

    /**
     * @param null $primary
     * @return static
     */
    public static function getNewRecord( $primary = null )
    {
        $Object = new static();
        if( $primary ){
            $Object->load($primary);
        }
        return $Object;
    }

    /**
     * @param $condition
     * @return bool
     */
    public static function exists( $condition )
    {
        $result = static::find(new Expression('COUNT(*) as has'))->where($condition)->one();
        return isset($result['has']) && $result['has'] >  0 ;
    }



}