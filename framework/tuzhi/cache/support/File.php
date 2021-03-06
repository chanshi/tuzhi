<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 14:22
 */

namespace tuzhi\cache\support;


use tuzhi\base\BObject;
use tuzhi\cache\CacheTrait;
use tuzhi\contracts\cache\ICache;
use tuzhi\support\fileStorage\FileSystem;

class File extends BObject implements ICache
{

    /**
     * Trait
     */
    use CacheTrait;

    /**
     * @var string
     */
    public $cacheDir = '&runtime/cache';

    /**
     * @var string
     */
    public $fileSuffix = '.cache';

    /**
     * @var null
     */
    protected $FileSystem = null;

    /**
     *
     */
    public function init()
    {
        $this->FileSystem = new FileSystem();
        // 注意了 
        $this->cacheDir =  rtrim( \Tuzhi::getAlias($this->cacheDir),'/' ).'/';
    }

    /**
     * @param $key
     * @return string
     * @throws \Exception
     */
    public function getPathFile( $key )
    {
        $fullKey = md5( $this->getKey($key) );
        $path = $this->cacheDir.substr($fullKey,0,1).'/'.substr($fullKey,1,2).'/';
        if( !is_dir($path) ){
            \tuzhi\helper\File::createDir($path,0755,true);
        }
        $file = $path.substr($fullKey,3).$this->fileSuffix;
        return $file;
    }

    /**
     * @param $key
     * @param null $value
     * @param int $expiry
     * @return mixed
     * @throws \Exception
     */
    public function set($key, $value = null, $expiry = 0)
    {
        $this->delete($key);

        $content['expiry']  = $expiry == 0 ? 0 : time() + $expiry;
        $content['content'] = $value;

        return $this->FileSystem->write(
            $this->getPathFile($key) ,
            $this->setContent( $content )
        );
    }

    /**
     * @param $key
     * @return mixed|null
     * @throws \Exception
     */
    public function get($key)
    {
        $result = $this->FileSystem->read( $this->getPathFile($key) );
        if($result){
            $content = $this->getContent($result);
            if( $content['expiry'] != 0 &&  $content['expiry'] < time() ){
                $this->delete($key);
                return null;
            }else {
                return $content['content'];
            }
        }else{
            return null;
        }
    }

    /**
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public function delete($key)
    {
        return $this->FileSystem->rm(
            $this->getPathFile($key)
        );
    }

    /**
     * 清空文件夹
     */
    public function flush()
    {
        \tuzhi\helper\File::clearDir($this->cacheDir , true);
    }

    /**
     * @param $key
     * @param int $step
     * @param int $expiry
     * @return int|mixed|null
     * @throws \Exception
     */
    public function increment($key, $step = 1,$expiry = 0)
    {
        $content = $this->get($key);

        $value = $content == null ? $step : ($content + $step );

        $this->set( $key , $value ,$expiry);

        return $value;
    }

    /**
     * @param $key
     * @param int $step
     * @param int $expiry
     * @return int|mixed
     * @throws \Exception
     */
    public function decrement($key, $step = 1,$expiry = 0)
    {
        $content = $this->get($key);

        $value = $content == null ? 0 : max(0,$content - $step);

        $this->set( $key , $value ,$expiry);

        return $value;
    }
}