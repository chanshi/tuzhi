<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/10
 * Time: 15:35
 */

namespace tuzhi\db\query;

/**
 * Class UpdateQuery
 * @package tuzhi\db\query
 */
class UpdateQuery extends Query
{
    /**
     * @var null
     */
    public $params;

    /**
     * UpdateQuery constructor.
     * @param null $table
     * @param null $params
     * @param array $config
     */
    public function __construct($table = null ,$params = null, array $config=[])
    {
        parent::__construct($config);

        if($table){
           $this->table($table);
        }
        if($params){
            $this->params = $params;
        }

    }

    /**
     * @return mixed
     */
    public function getSqlString()
    {
        return $this->db->getQueryBuild()->buildUpdate($this);
    }

    /**
     * @param null $params
     * @return mixed
     */
    public function update( $params = null )
    {
        if( $params ){
            $this->params = $params;
        }

        $sql = $this->getSqlString();

        return $this->db->transaction(function($db) use($sql) {
            return $db->createCommand($sql)->execute();
        });

    }
}