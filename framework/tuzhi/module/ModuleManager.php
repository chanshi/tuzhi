<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/9/5
 * Time: 14:44
 */

namespace tuzhi\module;


use tuzhi\base\Object;
use tuzhi\module\exception\NotFoundModuleException;

/**
 * Class ModuleManager
 * @package module
 */
class ModuleManager extends Object
{
    /**
     * @var
     */
    protected static $modules;

    /**
     * @var
     */
    public $modulePath;

    /**
     * @var array
     */
    public $moduleConfig = [];

    /**
     * @param $moduleName
     * @return mixed
     * @throws NotFoundModuleException
     */
    protected function getModuleConfig( $moduleName )
    {
        $configFile = isset( $this->moduleConfig[$moduleName] )
            ? $this->moduleConfig[$moduleName]
            : '/'.$moduleName.'/config/module.php';
        $configPath = rtrim($this->modulePath,'/').$configFile;

        if ( file_exists( $configPath ) ) {
            $config = ( include $configPath)['module'];
            return $config;
        }
        throw new NotFoundModuleException('Not Found Module Config '.$configPath.' files!');
    }

    /**
     * @param $module
     * @return mixed
     */
    public function getModule( $module )
    {
        $module = strtolower($module);
        if( ! isset(static::$modules[$module]) ){
            static::$modules[$module] = new Module( $this->getModuleConfig( $module ) );
        }
        return static::$modules[$module];
    }


}