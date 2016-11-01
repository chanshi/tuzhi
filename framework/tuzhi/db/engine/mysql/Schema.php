<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/30
 * Time: 15:20
 */

namespace tuzhi\db\engine\mysql;


use tuzhi\db\exception\NotFoundTableException;
use tuzhi\db\query\Expression;

class Schema extends \tuzhi\db\schema\Schema
{
    public static $typeMap=[];

    /**
     * @return mixed
     */
    public function showTables()
    {
        $_sql = 'SHOW TABLES';
        return $this->db->createCommand($_sql)->queryAll();
    }

    /**
     * @param $table
     * @return null
     */
    public function showCreateTable( $table )
    {
        $_sql = 'SHOW CREATE TABLE '.$this->quoteTableName($table).';';
        $result = $this->db->createCommand($_sql)->queryOne();
        if(isset($result['Create Table']) ){
            return $result['Create Table'] ;
        }else{
            return null;
        }
    }

    /**
     * @param $table
     * @return mixed
     */
    public function showFullColumn ($table)
    {
        $_sql = 'SHOW FULL COLUMNS FROM '.$this->quoteTableName($table);
        return $this->db->createCommand($_sql)->queryAll();
    }

    /**
     * @param $table
     * @return string
     */
    private function tableSchemaCacheKey( $table )
    {
        return md5( serialize([
            'db'=>$this->db->dbHashName,
            'tableName'=>$table
        ]));
    }

    /**
     * @param $table
     * @return mixed
     * @throws NotFoundTableException
     */
    public function getTableSchema( $table )
    {
        $CacheKey = $this->tableSchemaCacheKey($table);
        $Cache = $this->db->cache;
        if(($tableSchema = $Cache->get($CacheKey)) == null){
       // if( !( $tableSchema = $this->cache->get($table) ) ){
            $result = $this->showCreateTable($table);
            if($result == null){
                throw new NotFoundTableException('Not Found Table '.$table);
            }
            // 创建新对象
            $tableSchema = new $this->tableSchemaClass();
            $tableSchema->name = $table;
            $column = $this->showFullColumn($table);
            foreach($column as $col) {
                $columns = $tableSchema->getNewColumn();
                $columns->column = $col['Field'];
                $columns->allowNull = ($col['Null'] == 'YES') ;
                $columns->isPrimary = ($col['Key'] == 'PRI' ) ;
                $columns->isUnique  = ($col['Key'] == 'UNI') ;
                $columns->autoIncrement = $col['Extra'] == 'auto_increment' ;
                $columns->comment = $col['Comment'];
                $columns->defaultValue = $col['Default'] ? $col['Default'] : NULL ;
                $columns->unsigned = strpos($col['Type'],'unsigned') !== false ;

                if(preg_match('#^(\w+)(?:\(([^\)]+)\))?#',$col['Type'],$match)){
                    if(isset($match[1])){
                        $columns->type = $match[1];
                    }
                    if( $columns->type == 'enum' || $columns->type == 'set' ){
                        $value= explode(',',$match[2]);
                        foreach ($value as $i=> $v){
                            $value[$i] = trim($v,"'");
                        }
                        $columns->allowValue = $value;
                    }else if( isset($match[2]) ) {
                        $columns->size = $match[2];
                    }
                }

                if( $columns->type === 'timestamp' && $col['Default'] == 'CURRENT_TIMESTAMP' )
                {
                    $columns->defaultValue = new Expression('CURRENT_TIMESTAMP');
                }

                //更新字段
                $tableSchema->columns[ $columns->column ] = $columns;
                //跟新主键
                if( $columns->isPrimary ){
                    array_push($tableSchema->primaryKey,$columns->column);
                }
            }
            //TODO:: 外键信息

            //配置外键等信息
            $Cache->set($CacheKey,serialize($tableSchema));
            return $tableSchema;
        }
        return unserialize( $tableSchema );
    }
}