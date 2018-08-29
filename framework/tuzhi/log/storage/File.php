<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/5
 * Time: 11:22
 */

namespace tuzhi\log\storage;

use Tuzhi;
use tuzhi\base\BObject;
use tuzhi\contracts\log\IStorage;
use tuzhi\support\fileStorage\FileSystem;

/**
 * Class File
 * @package tuzhi\log\storage
 */
class File extends BObject implements IStorage
{
    /**
     * @var string
     */
    public $path = '&runtime/logs/{year}/{month}/{day}/';

    /**
     * @var string
     */
    public $file = '{type}.log';

    /**
     * @var
     */
    protected $fullFile ;

    /**
     * @var
     */
    protected $fileSystem;

    /**
     * @var
     */
    protected $format;

    /**
     * @throws \tuzhi\base\exception\InvalidParamException
     */
    public function init()
    {
        $this->fileSystem = new FileSystem();
        $this->path = rtrim( Tuzhi::alias($this->path),'/' ).'/';
        $this->format =
            [
                '#{year}#'=>date('Y'),
                '#{month}#'=>date('m'),
                '#{day}#'=>date('d'),
            ];
        $this->path = preg_replace(array_keys($this->format),array_values($this->format),$this->path);
        if( !is_dir($this->path)){
            \tuzhi\helper\File::createDir($this->path);
        }
    }

    /**
     * @param $type
     * @return string
     */
    public function getFileName( $type )
    {
        $this->format['#{type}#'] = $type;
        $file = preg_replace( array_keys($this->format), array_values($this->format), $this->file);
        return $this->path.$file;
    }

    /**
     * @param $message
     * @param $type
     * @return mixed
     */
    public function record( $message ,$type ){
        $this->fileSystem->append(
            $this->getFileName($type) ,
            is_array($message)
                ? join("\n",$message)."\n"
                : $message."\n"
        );
    }

    /**
     * @param $type
     * @return mixed
     */
    public function clean( $type )
    {
        $this->fileSystem->delete( $this->getFileName($type) );
    }
}