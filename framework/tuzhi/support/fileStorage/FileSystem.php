<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 14:43
 */

namespace tuzhi\support\fileStorage;


use tuzhi\base\exception\Exception;
use tuzhi\base\exception\NotFoundFilesException;
use tuzhi\contracts\support\fileStorage\IStorage;

class FileSystem implements IStorage
{

    /**
     * @param $file
     * @return null
     * @throws NotFoundFilesException
     */
    public function read($file)
    {
        if( $this->hasFile($file) ){
            return file_get_contents($file);
        }else{
            return null;
        }
    }

    /**
     * @param $file
     * @param $content
     * @return mixed
     * @throws NotFoundFilesException
     */
    public function write($file, $content)
    {
        if( $this->hasFile($file) ){
            $this->rm($file);
        }
        return file_put_contents($file,$content , LOCK_EX);

    }

    /**
     *
     * @param $file
     * @param $content
     * @return mixed
     */
    public function append( $file ,$content )
    {
        return file_put_contents( $file, $content , FILE_APPEND | LOCK_EX );
    }

    /**
     * @param $oldFileName
     * @param $newFileName
     * @return bool
     * @throws NotFoundFilesException
     */
    public function rename($oldFileName, $newFileName)
    {
        if( $this->hasFile($oldFileName) && ! $this->hasFile($newFileName) ){
            return rename($oldFileName,$newFileName);
        }else {
            return false;
        }
    }

    /**
     * @param $sourceFile
     * @param $targetFile
     * @return mixed
     * @throws NotFoundFilesException
     * @throws \Exception
     */
    public function move($sourceFile, $targetFile)
    {
        if( $this->hasFile($sourceFile,true) ){
            try{

                $this->copy($sourceFile,$targetFile);
            }catch(Exception $e){
                throw new \Exception('FileSystem Move File Exception ,sourceFile:'.$sourceFile.' , targetFile:'.$targetFile.'');
            }
            $this->rm($sourceFile);
        }
        return $targetFile;
    }

    /**
     * @param $sourceFile
     * @param $targetFile
     * @return mixed
     * @throws Exception
     * @throws NotFoundFilesException
     */
    public function copy($sourceFile, $targetFile)
    {
        if( $this->hasFile($sourceFile,true) ){
            try{
                copy($sourceFile ,$targetFile);
            }catch(Exception $e){
                throw new Exception( 'FileSystem Copy File Exception ,sourceFile:'.$sourceFile.' , and targetFile:'.$targetFile.'' );
            }
        }
        return $targetFile;
    }

    /**
     * @param $file
     * @return bool
     * @throws NotFoundFilesException
     */
    public function rm($file)
    {
        if( $this->hasFile($file) ){
            @unlink($file);
        }
        return true;
    }

    /**
     * @param $file
     * @param bool $throwException
     * @return bool
     * @throws NotFoundFilesException
     */
    public function hasFile( $file ,$throwException = false)
    {
        if( file_exists($file) ){
            return true;
        }else{
            if( $throwException == true ){
                throw new NotFoundFilesException('Not Found Files '.$file.' in FileSystem');
            }else{
                return false;
            }
        }
    }

}