<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/1
 * Time: 23:18
 */

namespace tuzhi\support\images;

use tuzhi\base\Object;
use tuzhi\support\files\Files;

abstract class ImagesServices extends Object
{
    /**
     *
     */
    const EVENT_BEFORE_SAVE = 'event.tuzhi.support.images.services.before.save';

    /**
     *
     */
    const EVENT_AFTER_SAVE  = 'event.tuzhi.support.images.services.after.save';

    /**
     * @var string 图片服务器域名
     */
    public $domain;

    /**
     * @param $imageFile
     */
    abstract  public function save( Files $imageFile );

    /**
     * @param $image
     * @param null $width
     * @param null $height
     * @return mixed
     */
    abstract  public function thumb( $image , $width = null  , $height = null );

    /**
     * @param $image
     * @return mixed
     */
    abstract public function remove( $image );
}