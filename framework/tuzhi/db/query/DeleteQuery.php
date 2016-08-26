<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/5/10
 * Time: 16:11
 */

namespace tuzhi\db\query;

/**
 * Class DeleteQuery
 * @package tuzhi\db\query
 */
class DeleteQuery extends Query
{

    /**
     * DeleteQuery constructor.
     * @param null $table
     * @param array $config
     */
    public function __construct($table=null,array $config=[])
    {
        parent::__construct($config);

        if( $table ){
            $this->table($table);
        }
    }

    /**
     * @return mixed
     */
    public function getSqlString()
    {
        return $this->db->getQueryBuild()->buildDelete($this);
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        $sql = $this->getSqlString();

        return $this->db->transaction(function($db)use($sql){
            return $db->createCommand($sql)->execute();
        });
    }
}