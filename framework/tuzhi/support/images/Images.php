<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/1
 * Time: 23:15
 */

namespace tuzhi\support\images;

use tuzhi\base\Object;

/**
 *
 * 设想
 * 1.图片存储
 * 2.提供图片服务
 * 3.图片裁剪？
 *
 * $service = [
 *       'class'=>'',
 *       'domain'=>'',
 *       'savePath'=>''
 *   ]
 *
 * Class Images
 * @package tuzhi\support\images
 */
class Images extends Object
{
    /**
     * @var 图片服务
     */
    public $service;

    /**
     *
     */
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if( $this->service ){
            $this->service = \Tuzhi::make($this->service);
        }
    }

    /**
     * @param $file Request::files()['upload']
     * @return array [ $img ,$url ,$error ]
     */
    public function save( $file )
    {
        if(is_array( $file )){
            $list = [];
            foreach ($file as $index=>$value){
                $list[$index] = $this->save($file);
            }
            return $list;
        }else{
            if(! $file->isSuccess() ){
                return [ '', '', $file->getErrorString()];
            }
            if( ! $file->isImages()) {
                return [ '', '' ];
            }

            $img = $this->service->save( $file );

            return [$img,$this->service->thumb($img)];
        }
    }

    /**
     * @param $img
     * @return mixed
     */
    public function thumb( $img )
    {
        return $this->service->thumb( $img );
    }

    /**
     * @param $img
     * @return mixed
     */
    public function remove( $img )
    {
        return $this->service->remove( $img );
    }

}