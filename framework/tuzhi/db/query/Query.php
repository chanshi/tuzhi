<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:30
 */

namespace tuzhi\db\query;

use tuzhi\base\Object;
use tuzhi\db\query\section\GroupTrait;
use tuzhi\db\query\section\HavingTrait;
use tuzhi\db\query\section\LimitTrait;
use tuzhi\db\query\section\OrderTrait;
use tuzhi\db\query\section\SelectTrait;
use tuzhi\db\query\section\TableTrait;
use tuzhi\db\query\section\WhereTrait;
use tuzhi\db\query\Expression;

class Query extends Object
{

    /**
     * @var
     */
    public $db;

    const _AS_ ='AS';
    const _AND_ ='AND';
    const _OR_  ='OR';

    const JOIN ='JOIN';
    const LEFT_JOIN ='LEFT JOIN';
    const RIGHT_JOIN='RIGHT JOIN';

    const F_COUNT = 'COUNT';
    const F_SUM = 'SUM';
    const F_AVG = 'AVG';

    const ASC = 'ASC';
    const DESC ='DESC';

    const EQ  = '=';
    const NEQ = '<>';
    const GT  = '>';
    const GE  = '>=';
    const LT  = '<';
    const LE  = '<=';

    const BETWEEN = 'BETWEEN';
    const NOT_BETWEEN = 'NOT BETWEEN';

    const LIKE = 'LIKE';
    const NOT_LIKE = 'NOT LIKE';

    const IS_NULL = 'IS NULL';
    const IS_NOT_NULL = 'IS NOT NULL';

    const IN ='IN';
    const NOT_IN ='NOT IN';

    const EXISTS ='EXISTS';
    const NOT_EXISTS = 'NOT EXISTS';

    const REGEXP ='REGEXP';
    const NOT_REGEXP= 'NOT REGEXP';
    
    const UNIQUE ='UNIQUE';


    /**
     * Select
     */
    use SelectTrait;

    /**
     * Table
     */
    use TableTrait;

    /**
     * Where
     */
    use WhereTrait;

    /**
     *
     */
    use GroupTrait;

    /**
     *
     */
    use HavingTrait;

    /**
     *
     */
    use OrderTrait;

    /**
     *
     */
    use LimitTrait;


    /**
     *
     */
    public function init()
    {
        if( $this->db == null ){
            $this->db = \Tuzhi::App()->db();
        }
    }


    /**
     * @return mixed
     */
    public function one()
    {
        return $this->db->createCommand( $this->getSqlString() )->queryOne();
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->db->createCommand( $this->getSqlString() )->queryAll();
    }

    /**
     * @param string $column
     * @return mixed
     */
    public function count( $column = '*' )
    {
        return $this->queryScalar("count($column)");
    }

    /**
     *
     * @param $column
     * @return mixed
     */
    public function sum( $column )
    {
        $column = $this->db->quoteColumn($column);
        return $this->queryScalar("SUM({$column})");
    }

    /**
     *
     * @param $selectExpression
     * @return mixed
     */
    public function scalarExpression(  $selectExpression )
    {
        $select = $this->select;
        $limit = $this->limit;

        $this->limit = null;
        if( empty($this->group) && empty($this->having) ){
            if( is_array($selectExpression) ){
                $this->select = $selectExpression;
            }else{
                $this->select = [$selectExpression];
            }
            $sql = $this->db->getQueryBuild()->build($this);
        }else{
            $Query = (new Query(['db'=>$this->db]))
                ->select($selectExpression)
                ->table($this ,'a');
            $sql = $this->db->getQueryBuild()->build($Query);
        }

        $this->select = $select;
        $this->limit = $limit;

        return $this->db->createCommand($sql)->queryOne();
    }

    /**
     * @param $selectExpression
     * @return mixed
     */
    protected function queryScalar( $selectExpression )
    {
        $select = $this->select;
        $limit = $this->limit;

        $this->limit = null;

        if( empty( $this->group) && empty($this->having) ){
            $this->select = [$selectExpression];
            $sql = $this->db->getQueryBuild()->build($this);
        }else{
            $Query = (new Query(['db'=>$this->db]) )
                ->select(new Expression( $selectExpression ))
                ->table($this,'a');
            $sql = $this->db->getQueryBuild()->build($Query);
        }

        $this->select = $select;
        $this->limit = $limit;
        return $this->db->createCommand($sql)->queryScalar();

    }


    /**
     * @return mixed
     */
    public function getSqlString()
    {
        return $this->db->getQueryBuild()->build($this);
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->getSqlString();
    }


}