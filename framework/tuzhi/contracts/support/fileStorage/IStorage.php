<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/27
 * Time: 14:50
 */

namespace tuzhi\contracts\support\fileStorage;


interface IStorage
{
    /**
     *  读文件
     * @param $file
     * @return mixed
     */
    public function read( $file );

    /**
     * 写文件
     * @param $file
     * @param $content
     * @return mixed
     */
    public function write( $file ,$content );

    /**
     * 改名
     * @param $oldFileName
     * @param $newFileName
     * @return mixed
     */
    public function rename( $oldFileName , $newFileName);

    /**
     * 移动文件
     * @param $sourceFile
     * @param $targetFile
     * @return mixed
     */
    public function move( $sourceFile , $targetFile );

    /**
     * 拷贝文件
     * @param $sourceFile
     * @param $targetFile
     * @return mixed
     */
    public function copy( $sourceFile , $targetFile );

    /**
     * 删除文件
     * @param $file
     * @return mixed
     */
    public function rm( $file );
}