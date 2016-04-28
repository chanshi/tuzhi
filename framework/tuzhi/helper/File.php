<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/24
 * Time: 11:22
 */

namespace tuzhi\helper;


class File
{
    const DS = DIRECTORY_SEPARATOR;

    /**
     * @param $dir
     * @param int $mode
     * @param bool $force
     * @return bool
     * @throws \Exception
     */
    public static function createDir( $dir, $mode=0777 , $force = true){
       return File::createDirection($dir ,$mode ,$force);
    }

    /**
     * @param $dir
     * @param int $mode
     * @param bool $force
     * @return bool
     * @throws \Exception
     */
    public static function createDirection( $dir ,$mode = 0775 ,$force = true )
    {
        if(is_dir($dir) ){
            return true;
        }

        $parentDir = dirname( $dir );

        if( $force && ! is_dir($parentDir) && $parentDir != $dir ){
            File::createDirection($parentDir,$mode ,true);
        }

        try {
            if( ! mkdir( $dir ,$mode ) ){
                return false;
            }
        }catch(\Exception $e){
            if( !is_dir($dir) ){
                throw new \Exception('Cant create dir '.$dir.' message '.$e->getMessage().' ',$e->getCode(),$e);
            }
        }

        try{
            return chmod( $dir ,$mode );
        }catch(\Exception $e){
            throw new \Exception('Cant chmod dir '.$dir.' message '.$e->getMessage(),$e->getCode(),$e);
        }
    }

    /**
     * @return bool
     */
    public static function isWindows()
    {
        return File::DS == '\\'
            ? true
            : false;
    }

    /**
     * @return bool
     */
    public static function isLinux()
    {
        return File::isWindows()
            ? false
            : true;
    }



    /**
     * @param $dir
     * @param bool $force
     * @return bool
     */
    public static function clearDir( $dir ,$force = false ){
        $_ds = '/';

        $dir = rtrim( $dir , $_ds ) .$_ds;
        if( is_dir( $dir ) && !is_link($dir) ){
            $_dir = opendir($dir);
            while( $file = readdir( $_dir ) ){
                if( $file == '.' || $file =='..') continue;
                //if( substr($file,0,1) == '.') continue;
                if( is_dir( $dir.$file ) && $force ) {
                    File::clearDir( $dir.$file ,$force );
                    @rmdir($dir.$file);
                }else{
                    @unlink($dir.$file);
                }
            }
            closedir($_dir);
        }
        return true;
    }
}