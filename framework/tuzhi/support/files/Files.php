<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/11/1
 * Time: 10:51
 */

namespace tuzhi\support\files;

use tuzhi\base\BObject;

/**
 * Class Files
 * @package tuzhi\support\files
 */
class Files extends BObject
{

    /**
     * @var
     */
    public $file;

    /**
     * @var array
     */
    protected static $errorString =
        [
            -1 => '无此文件',
            0  => '成功',
            1  => '文件过大',
            2  => '文件超过大小限制',
            3  => '文件部分上传',
            4  => '文件没被上传',
            5  => '文件大小0',
        ];

    /**
     * @param bool $isFull
     * @return string
     */
    public function getName( $isFull = false )
    {
        return isset( $this->file['name'] )
            ? ( $isFull
                ? $this->file['name']
                :  ( $this->getSuffix()
                    ? substr( $this->file['name'],0,( 0 - ( strlen( $this->getSuffix())+1 ) ) )
                    : $this->file['name'] ) )
            : 'none';
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        if(isset( $this->file['name'] )){
            $exp = explode('.',$this->file['name']);
            return strtolower(  end($exp) );
        }else{
            return '';
        }
    }

    /**
     * @return null
     */
    public function getFiles()
    {
        return isset( $this->file['tmp_name'])
            ? $this->file['tmp_name']
            : null;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return isset( $this->file['type'] )
            ? $this->file['type']
            : 'application/octet-stream';
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return isset( $this->file['error'] )
            ? ( $this->file['error'] == 0 )
            : false;
    }

    /**
     * @return bool
     */
    public function isImages()
    {
        return in_array(strtolower($this->getSuffix()),
            ['gif','jpg','jpe','jpeg','png']);
    }

    /**
     * 获取错误Code
     *
     * @return int
     */
    public function getErrorCode()
    {
        return isset($this->file['error'])
            ? $this->file['error']
            : -1;
    }

    /**
     * 获取错误String
     *
     * @return mixed
     */
    public function getErrorString()
    {
        return static::$errorString[$this->getErrorCode()];
    }

    /**
     * @return bool
     */
    public function rm()
    {
       return  @unlink( $this->getFiles() );
    }
}