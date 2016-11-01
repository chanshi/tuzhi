<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/29
 * Time: 15:33
 */

namespace tuzhi\db\query\section;
use tuzhi\db\query\Query;


/**
 * Class TableTrait
 * @package tuzhi\db\query\section
 */
trait TableTrait
{

    /**
     * @var
     */
    public $table;

    /**
     * @var
     */
    public $join;

    /**
     * @param $table or  Query
     * @param null $alias
     * @return $this
     */
    public function table( $table ,$alias = null )
    {
        $table = $this->db->quoteTable($table);
        $this->table[] = $alias
            ? [$table, Query::_AS_ ,$alias]
            : [$table];

        return $this;
    }

    /**
     * 这个 
     * @return null
     */
    public function getOneTable()
    {
        if( count( $this->table ) == 1 && isset($this->table[0][0]) )
        {
            return $this->table[0][0];
        }
        return null;
    }

    /**
     * @param $table
     * @param $alias
     * @param null $condition
     * @return $this
     */
    public function join( $table , $alias , $condition = null)
    {
        $table = $this->db->quoteTable($table);
        $this->join[] =[[$table,Query::_AS_,$alias] ,Query::JOIN, $condition ];

        return $this;
    }

    /**
     * @param $table
     * @param $alias
     * @param null $condition
     * @return $this
     */
    public function leftJoin($table , $alias, $condition = null)
    {
        $table = $this->db->quoteTable($table);

        $this->join[] =[[$table,Query::_AS_,$alias] ,Query::LEFT_JOIN , $condition ];

        return $this;
    }

    /**
     * @param $table
     * @param $alias
     * @param null $condition
     * @return $this
     */
    public function rightJoin($table , $alias , $condition = null)
    {
        $table = $this->db->quoteTable($table);

        $this->join[] =[[$table,Query::_AS_,$alias] ,Query::RIGHT_JOIN,$condition ];

        return $this;
    }

    /**
     * @param $table
     * @return mixed
     */
    private function quoteTable( $table )
    {
        if(is_string($table)){
            $table = $this->db->quoteTable($table);
        }
        return $table;
    }


}