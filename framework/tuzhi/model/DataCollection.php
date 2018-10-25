<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/31
 * Time: 17:59
 */

namespace tuzhi\model;


use tuzhi\contracts\model\IDataCollection;
use tuzhi\db\query\Query;


/**
 * Class DataCollection
 * @package app\model
 */
class DataCollection extends Model implements IDataCollection
{
    /**
     * @var string
     */
    public $Pager = 'tuzhi\model\pager\BasePager';

    /**
     * @var bool
     */
    protected $enablePager = true;


    protected $enableCount = true;

    /**
     * @var
     */
    protected $data = [];

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $pageSize =30;

    /**
     *
     */
    //protected $attDeny = ['data','page','pageSize','Pager'];

    /**
     * @var
     */
    protected $Query;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->Query = \DB::Query();
        $this->Pager = new $this->Pager();

    }

    /**
     * @param bool $enable
     * @return $this
     */
    public function setEnablePager( bool $enable  )
    {
        $this->enablePager = $enable;
        return $this;
    }

    /**
     *
     * @param bool $enable
     * @return $this
     */
    public function setEnableCount( bool $enable)
    {
        $this->enableCount = $enable;
        return $this;
    }

    /**
     * @param int $page
     * @param int $pageSize
     */
    final public function setPage(  $page = 1,  $pageSize =30)
    {
        $this->page = max(1,$page);
        $this->pageSize = $pageSize;
    }

    /**
     * @return string
     */
    public function getPager()
    {
        return $this->Pager;
    }

    /**
     * @return mixed
     */
    public function buildQuery(){}

    /**
     * @return mixed
     */
    public function query()
    {
        $this->buildQuery();
        if( $this->enablePager && $this->Query instanceof Query) {
            $this->Query->limit(
                ($this->page - 1) * $this->pageSize,
                $this->pageSize
            );

           $count =  $this->enableCount
               ? $this->Query->count()
               : 1000000000;

            $this->Pager->setTotal($count)
                ->setPage($this->page)
                ->setPageSize($this->pageSize)
                ->build();
        }
        $this->data = $this->Query->all();
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->Query;
    }

    /**
     * @return \ArrayIterator
     */
    public  function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

}