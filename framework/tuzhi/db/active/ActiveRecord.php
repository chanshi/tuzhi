<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/25
 * Time: 10:35
 */

namespace tuzhi\db\active;


use tuzhi\base\exception\InvalidParamException;
use tuzhi\helper\Arr;
use tuzhi\model\Model;
use tuzhi\validators\Validator;

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
     * @var array 禁止更新字段
     */
    protected $denyUpdateColumns = [];

    /**
     * @var array 自动更新
     */
    protected $autoUpdateColumns = [];

    /**
     * @var bool
     */
    private $loadDb = false;

    /**
     * ActiveRecord constructor.
     * @param null $primary
     * @param array $config
     */
    public function __construct( $primary = null ,array $config=[])
    {
        parent::__construct($config);
        // load;
        if($primary !== null)
        {

            $this->loadByPrimary( $primary );
        }
    }

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->db = \Tuzhi::App()->db();

        $this->loadTableSchema();
        $this->primaryKey = $this->tableSchema->getPrimaryKey();
        $this->columns = $this->tableSchema->getAllColumns();
    }

    /**
     * @param $primary
     * @throws InvalidParamException
     */
    protected function initPrimary( $primary )
    {
        if( is_array($primary) && count($this->primaryKey) == count($primary) )
        {
            $this->primary = array_combine($this->primaryKey,$primary);

        }else if(count($this->primaryKey)== 1 )
        {
            $this->primary = array_combine($this->primaryKey,[$primary]);
        }else{

            throw new InvalidParamException('Invalid Params the Model::initPrimary primary :'.json_encode($primary) );
        }

    }

    /**
     * @return mixed
     */
    protected function loadTableSchema()
    {
        if( $this->tableSchema == null ){

            $this->tableSchema = $this->db->getTableSchema( static::tableName() );
        }
        return $this->tableSchema;
    }

    public function setAttribute($attribute, $value)
    {
        if( ! in_array($attribute,$this->columns) )
        {
            return false;
        }
        //初始值
        if( !isset( $this->attributes[$attribute] ) )
        {
            $this->attributes[$attribute] = $value;
            if( in_array($attribute ,$this->primaryKey) ){
                $this->primary[$attribute] = $value;
            }
            return true;
        }
        if( $this->loadDb )
        {
            if( in_array($attribute ,$this->denyUpdateColumns) ){
                return false;
            }
            if( in_array($attribute ,$this->primaryKey) ){
                return false;
            }
            if( ! isset($this->oldAttributes[$attribute]) ){
                $this->oldAttributes[$attribute] = $this->attributes[$attribute];
            }
        }

        $this->attributes[$attribute] = $value;
        return true;
    }

    /**
     * @return bool
     */
    public function isNewRecord()
    {
        return empty( $this->oldAttributes );
    }

    /**
     * @return bool
     */
    public function hasDirtyAttribute()
    {
        return count($this->oldAttributes) > 0;
    }

    /**
     * @return mixed 获取需要更新的数据
     */
    public function getDirtyAttributes()
    {
        $keys = array_keys($this->oldAttributes);

        return Arr::filter($this->attributes,$keys);
    }

    /**
     * @param null $data
     * @return bool|mixed
     */
    public function save( $data = null )
    {
        if($data !== null)
        {
            $this->setAttributes($data);
        }

        if( $this->loadDb )
        {
            if( $this->hasDirtyAttribute() ){

                return $this->updateAttribute($this->getDirtyAttributes());
            }
            return true;
        }
        //TODO:: 根据主键 主要根据 主键一般为自增ID
        if( count( $this->primary ) > 0 ){
            return $this->updateAttribute($this->attributes);
        }else{
            return $this->insertAttribute($this->attributes);
        }
    }

    /**
     * @param $data
     * @return bool|mixed
     */
    protected function updateAttribute( $data )
    {
        if( $this->valid($data,Validator::TYPE_SEGMENT) ){

            return static::update($data)
                ->where($this->primary)
                ->update();

        }
        return false;
    }

    /**
     * @param $data
     * @return bool|mixed
     */
    protected function insertAttribute( $data )
    {
        if( $this->valid($data ,Validator::TYPE_SEGMENT) ){

            return static::insert($data);

        }
        return false;
    }


    /**
     * @param null $key
     * @return bool
     */
    public function loadByPrimary( $key = null )
    {
        if( $key != null){
            $this->initPrimary($key);
        }

        $attribute = static::find()->where($this->primary)->one();

        if( $attribute ){
            $this->setAttributes($attribute);
            $this->loadDb = true;
            return true;
        }
        return false;
    }
}