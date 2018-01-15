<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/4
 * Time: 21:17
 */

/**
 * Class DB
 */
class DB
{
    /**
     * @var
     */
    protected static $instance;

    /**
     * @return \tuzhi\db\query\Query
     */
    public static function Query()
    {
        return new \tuzhi\db\query\Query();
    }

    /**
     * @param $sql
     * @return mixed
     */
    public static function SQL( $sql )
    {
        return static::getDb()->createCommand($sql);
    }

    /**
     * @return mixed
     */
    public static function getDb()
    {
        if( static::$instance == null){
            static::$instance = Tuzhi::App()->get('db');
        }
        return static::$instance;
    }

    /**
     * @param $expression
     * @return \tuzhi\db\query\Expression
     */
    public static function Expression( $expression )
    {
        return new \tuzhi\db\query\Expression($expression);
    }

    /**
     * @return mixed
     */
    public static function Begin()
    {
        $transaction = DB::getDb()->getTransaction();
        $transaction->begin();
        return $transaction->getLevel();
    }

    /**
     * @param $transactionLevel
     * @return bool
     */
    public static function Commit( $transactionLevel )
    {
        $transaction = DB::getDb()->getTransaction();
        if( $transaction->getLevel == $transactionLevel ){
            $transaction->commit();
            return true;
        }
        return false;

    }

    /**
     * @param $transactionLevel
     * @return bool
     */
    public static function Rollback( $transactionLevel)
    {
        $transaction = DB::getDb()->getTransaction();
        if( $transaction->getLevel() == $transactionLevel ){
            $transaction->rollback();
            return true;
        }
        return false;
    }
}