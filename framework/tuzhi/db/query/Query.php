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

class Query extends Object
{

    public $db;

    const AS ='AS';

    const JOIN ='JOIN';
    const LEFTJOIN ='LEFT JOIN';
    const RIGHTJOIN='RIGHT JOIN';

    const F_COUNT = 'COUNT';
    const F_SUM = 'SUM';
    const F_AVG = 'AVG';

    const ASC = 'ASC';
    const DESC ='DESC';

    const AND ='AND';
    const OR  ='OR';

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