<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:39
 */

namespace tuzhi\db\schema;


use tuzhi\db\query\QueryBuilder;

class Schema
{

    public $builder;

    
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
}