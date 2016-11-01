<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:35
 */

namespace tuzhi\db\active;


use tuzhi\base\exception\InvalidParamException;
use tuzhi\db\Connection;
use tuzhi\helper\Arr;
use tuzhi\model\Model;
use tuzhi\db\query\InsertQuery;
use tuzhi\db\query\UpdateQuery;
use tuzhi\db\query\DeleteQuery;

/**
 * Class ActiveRecord
 * @package tuzhi\db\active
 */
class ActiveRecord extends Model
{
    /**
     * Trait
     */
    use ActiveRecordTrait;

    /**
     * @var db
     */
    protected $db;

    /**
     * @var
     */
    protected $tableSchema;

    /**
     * @var
     */
    protected $primaryKey;

    /**
     * @var
     */
    protected $primary;

    /**
     * @var
     */
    protected $columns;

    /**
     * @var array
     */
    protected $oldAttr = [];

    /**
     * @var array
     */
    protected $defaultAttr = [];

    /**
     * @var array 禁止更新字段
     */
    protected $denyUpdate = [];

    /**
     * @var array 自动更新
     */
    protected $autoUpdateColumns = [];

    /**
     * @var bool
     */
    private $loadDb = false;


    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->defaultAttr = $this->defaultAttr ? $this->defaultAttr : $this->initDefaultAtt();
        $this->db =  $this->db instanceOf Connection
            ? $this->db
            :   \Tuzhi::App()->get( $this->db ? $this->db : 'db' );

        $this->loadTableSchema();
    }

    /**
     * @return array
     */
    protected function initDefaultAtt()
    {
        return [];
    }

    /**
     * @param $attribute
     * @return bool
     */
    protected function isPrimaryAtt( $attribute )
    {
        return in_array($attribute,$this->primaryKey);
    }

    /**
     * @return bool
     */
    protected function hasPrimary()
    {
        foreach($this->primaryKey as $key)
        {
            if( ! isset( $this->primary[$key] ) || $this->primary[$key] == null ){
                return false;
            }
        }
        return true;
    }

    /**
     * @return mixed
     */
    protected function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @param $attribute
     * @return mixed|null
     */
    protected function getDefault( $attribute )
    {
        if(isset($this->defaultAttr[$attribute])){
            if( $this->defaultAttr[$attribute] instanceof \Closure){
                return call_user_func($this->defaultAttr[$attribute]);
            }else {
                return $this->defaultAttr[$attribute];
            }
        }
        return null;
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    protected function setPrimary( $attribute,$value )
    {
        if($this->isPrimaryAtt($attribute) && !isset($this->primary[$attribute])) {
            $this->primary[$attribute] = $value;
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    protected function loadTableSchema()
    {
        if( $this->tableSchema == null ){
            $this->tableSchema = $this->db->getTableSchema( static::tableName() );
            $this->primaryKey = $this->tableSchema->primary();
            $this->attAllow = $this->tableSchema->columns();
        }
        return $this->tableSchema;
    }

    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function setAttribute($attribute, $value)
    {

        if( $this->loadDb ) {
            //TODO::禁止设置 主键


            if( in_array($attribute ,$this->denyUpdate) ){
                return false;
            }

            if( isset($this->attributes[$attribute]) && ($this->attributes[$attribute] != $value) ){
                $this->oldAttr[$attribute] = $this->attributes[$attribute];
                $this->attributes[$attribute] = $value;
            }
        }else{
            if( parent::setAttribute($attribute,$value) == false){
                return false;
            }

            if( $this->setPrimary($attribute,$value) == false) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isNewRecord()
    {
        return $this->loadDb
            ? false
            : true;
    }

    /**
     * @return bool
     */
    public function hasDirtyAttribute()
    {
        return $this->oldAttr == []
            ? false
            : true;
    }

    /**
     * @return mixed 获取需要更新的数据
     */
    public function getDirtyAttributes()
    {
        $keys = array_keys($this->oldAttr);

        return Arr::filter($this->attributes,$keys);
    }

    /**
     * @param null $data
     * @return bool|mixed
     */
    public function save( $data = null )
    {
        if( $data ) {
            $this->setAttributes($data);
        }

        if( $this->loadDb )
        {
            if( $this->hasDirtyAttribute() ){

                return $this->modify();
            }
            return true;
        }
        //TODO:: 根据主键 主要根据 主键一般为自增ID
        if( $this->hasPrimary() ){
            return $this->modify();
        }else{
            return $this->add();
        }
    }

    /**
     * @return mixed
     */
    protected function addInitDefault()
    {
        foreach($this->attAllow as $attribute) {
            if(!isset($this->attributes[$attribute])){
                $this->setAttribute($attribute,$this->getDefault($attribute));
            }
        }
    }


    /**
     * @param null $data
     * @param bool $isVerify
     * @return bool|mixed
     * @throws \Exception
     */
    public function add( $data = null , $isVerify = true)
    {
        if( $data ) {
            $this->setAttributes($data);
        }

        if( empty( $this->attributes ) ) {
            $this->setErrorMessage('Attributes is Empty');
            return false;
        }

        // 加载初始化值
        $this->addInitDefault();

        //添加验证
        if(  $isVerify  && ! $this->verify() ){
            return false;
        }

        $transaction = $this->db->getTransaction();
        $transaction->begin();
        $level = $transaction->getLevel();
        try{

            $result = (new InsertQuery( static::tableName() , null ,['db'=>$this->db] ) )->insert( $this->attributes );

            if( $transaction->getLevel() == $level){
                $transaction->commit();
            }

            if( $result > 0 ){
                ////TODO 自增ID
                $this->setAttribute($this->primaryKey[0],$result);
            }
        }catch(\Exception $e) {
            if( $transaction->getLevel() == $level){
                $transaction->rollback();
            }
            throw $e;
        }

        return $result;

    }

    /**
     * @param null $data
     * @param bool $isVerify
     * @return bool|mixed
     * @throws \Exception
     */
    public function modify( $data = null ,$isVerify = true)
    {
        if( $data ){
            $this->setAttributes($data);
        }
        if( $this->hasPrimary() ) {

            $data = $this->hasDirtyAttribute()
                ? $this->getDirtyAttributes()
                : $this->attributes;

            //添加验证
            if( $isVerify && ! $this->verify(array_keys($data)) ){
                return false;
            }

            $transaction = $this->db->getTransaction();
            $transaction->begin();
            $level = $transaction->getLevel();
            try{

                $result = (new UpdateQuery(static::tableName(),null,['db'=>$this->db]))
                    ->where( $this->getPrimary() )
                    ->update($data);

                if( $transaction->getLevel() == $level){
                    $transaction->commit();
                }
                return $result;
            }catch(\Exception $e){

                if( $transaction->getLevel() == $level){
                    $transaction->rollback();
                }
                throw $e;
            }
        }
        $this->setErrorMessage('Primary is empty Modify Error');
        return false;
    }


    /**
     * @return bool|mixed
     * @throws \Exception
     */
    public function remove()
    {
        if( $this->hasPrimary() ){

            $transaction = $this->db->getTransaction();
            $transaction->begin();
            $level = $transaction->getLevel();
            try{
                $result = (new DeleteQuery(static::tableName(),['db'=>$this->db]))
                    ->where( $this->getPrimary() )
                    ->delete();

                if( $transaction->getLevel() == $level){
                    $transaction->commit();
                }
                return $result;
            }catch(\Exception $e){
                if( $transaction->getLevel() == $level){
                    $transaction->rollback();
                }
                throw $e;
            }
        }
        $this->setErrorMessage('Primary is empty Remove Error');
        return false;
    }

    /**
     * @param $primary
     * @return $this
     */
    public function load( $primary )
    {
        if( is_array($primary) ) {
            $this->setAttributes($primary);
        }else{
            $this->setAttribute($this->primaryKey[0],$primary);
        }

        if( $this->hasPrimary() ){
            $attributes = static::find()->where($this->getPrimary())->one();
            if( $attributes ){
                $this->setAttributes($attributes);
                $this->loadDb = true;
                return $this;
            }else{
                $this->setErrorMessage('Not Found Attribute By Primary Key');
            }
        }else{
            $this->setErrorMessage('Load Error Primary is empty');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function hasLoad()
    {
        return $this->loadDb ;
    }

}