<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 2016/12/2
 * Time: 16:24
 */

namespace tuzhi\console\control;

use tuzhi\console\Control;
use tuzhi\helper\File;

class AppCtl extends Control
{
    /**
     * @return array
     */
    public function helpAct()
    {
        parent::helpAct();
        return [
            'create' =>'创建app',
            'drop'=>'整体删除app'
        ];
    }


    public function createAct()
    {
        $this->info('App 创建');

        getDir :
        $appPath = '/Users/sunhaifeng/test/app';
        $appPath = rtrim($appPath,'/').'/';
        if( ! is_dir($appPath) ){
            File::createDirection($appPath);
            $this->info('Create APP Dir '.$appPath.' done!');
        }else{
            $this->info('目录已经存在！');
            if($this->confirm('是否删除原先的APP') ){
                File::clearDir($appPath);
                goto  getDir;
            }else{
                return 'done';
            }

        }

        $this->createAppDir($appPath);
        $this->copyConfig($appPath.'config');
        $this->createEntryFile($appPath.'public');
        $this->createControl($appPath.'control','Index');

        $this->info('项目创建完成！');
    }

    public function dropAct()
    {
        $this->info('App 删除');
        $appPath = '/Users/sunhaifeng/test/app';

        File::clearDir($appPath);

    }

    protected function createAppDir( $basePath )
    {
        $dirMap =
            [
                'config',
                'control',
                'public',
                'runtime',
                'resource',
                'resource/view',
                'resource/asset',
                'resource/layout',
                'resource/widget'
            ];
        $this->info('创建APP 基本目录');
        foreach ($dirMap as $dir)
        {
            $dir = rtrim( $basePath,'/').'/'.$dir;
            File::createDirection( $dir );
            $this->info('创建目录 '.$dir.' done!');
        }
    }

    protected function copyConfig( $dir )
    {
        $stubMaps =
            [
                'alias.php.stub',
                'app.php.stub',
                'config.php.stub',
                'namespace.php.stub'
            ];
        $path = rtrim( \Tuzhi::alias('&tuzhi/console/stub/app/config') ,'/' ).'/';
        $dir = rtrim($dir,'/').'/';

        foreach ($stubMaps as $stub){
            $content = file_get_contents($path.$stub);
            file_put_contents($dir.substr($stub,0,-5),$content);
            $this->info('生成配置文件 '. $dir.substr($stub,0,-5) .' done!');
        }
    }

    protected function createEntryFile( $dir )
    {
        $file = rtrim( \Tuzhi::alias('&tuzhi/console/stub/app/public') ,'/' ).'/';
        $entry = file_get_contents( $file.'index.php.stub');
        //
        $entry = str_replace('ENTRYDIR',TUZHI_PATH.'/tuzhi.php',$entry);
        file_put_contents($dir.'/'.'index.php',$entry);
        $this->info('生成入口文件 index.php done!');
    }

    protected function createControl($dir ,$Name)
    {
        $file = rtrim( \Tuzhi::alias('&tuzhi/console/stub/app/control') ,'/' ).'/';
        $Control = file_get_contents( $file.'Controler.php.stub');

        $Control = str_replace('TCName',$Name,$Control);
        file_put_contents($dir.'/'.$Name.'.php',$Control);
        $this->info('生成控制器文件 '.$Name.'.php done!');
    }
}