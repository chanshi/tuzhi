<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/24
 * Time: 11:22
 */

namespace tuzhi\helper;

use tuzhi\base\exception\InvalidParamException;

class File
{

    /**
     * @param $dir
     * @param int $mode
     * @param bool $force
     * @return bool
     * @throws InvalidParamException
     */
    public static function createDir( $dir, $mode=0777 , $force = true){
        $_ds = '/';
        if(is_dir($dir)){
            @chmod($dir,$mode);
            return true;
        }

        $_dir =  rtrim(  str_ireplace('\\',$_ds,$dir)  , $_ds );
        $_thePath  = substr($_dir,0,strripos($_dir,$_ds));
        $_theFile  = substr($_dir,strripos($_dir,$_ds));

        // 这里有问题
        //if( ! ( empty($_thePath) || (stripos($_thePath,':') && count($_thePath) == 2) ) && $force ){
         //   File::createDir($_thePath,$mode,$force);
        //}

        try{
            mkdir($_thePath.$_theFile);
            chmod($_thePath.$_theFile,$mode);
        }catch(\Exception $e){
            throw new InvalidParamException( 'Cant Create Dir '.$_thePath.$_theFile.' ' );
        }
        return true;
    }

    /**
     * @param $dir
     * @param bool $force
     * @return bool
     */
    public static function clearDir( $dir ,$force = false ){
        $_ds = '/';

        $dir = rtrim( $dir , $_ds ) .$_ds;
        if( is_dir( $dir ) ){
            $_dir = opendir($dir);
            while( $file = readdir( $_dir ) ){
                if( $file == '.' || $file =='..') continue;
                if( substr($file,0,1) == '.') continue;
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