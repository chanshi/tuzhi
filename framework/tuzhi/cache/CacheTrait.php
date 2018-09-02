<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 12:03
 */

namespace tuzhi\cache;


use tuzhi\helper\Json;

trait CacheTrait
{
    /**
     * @var string
     */
    public $keyPrefix = 'cache_';

    /**
     *
     */
    public $contentEncode = 'serialize';

    /**
     * @var string
     */
    public $contentDecode = 'unserialize';

    /**
     * @param $key
     * @return string
     */
    public function getKey( $key )
    {
        return $this->keyPrefix.$key;
    }

    /**
     * @param $content
     * @return mixed
     */
    protected function setContent( $content )
    {
        $method = $this->contentEncode;
        if ($method == 'json'){
            return Json::encode($content);
        }else{
            return $method($content);
        }
    }

    /**
     * @param $content
     * @return mixed
     */
    protected function getContent( $content )
    {
        $method = $this->contentDecode;
        if ($method == 'json'){
            return Json::decode($content);
        }else{
            return $method($content);
        }
    }
}