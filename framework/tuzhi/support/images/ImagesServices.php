<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/1
 * Time: 23:18
 */

namespace tuzhi\support\images;

use tuzhi\base\BObject;
use tuzhi\support\files\Files;

abstract class ImagesServices extends BObject
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
     * @param int $width
     * @param int $height
     * @param string $suffix
     * @return mixed
     */
    abstract  public function thumb( $image , $width = 0  , $height = 0 ,$suffix='.jpg');

    /**
     * @param $image
     * @return mixed
     */
    abstract public function remove( $image );
}