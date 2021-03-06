<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/8
 * Time: 23:14
 */

namespace tuzhi\base;


abstract class ErrorHandler extends Server
{
    /**
     * @var
     */
    public $exception;
    

    /**
     * 注册
     */
    public function start()
    {
        //关闭错误显示  移交错误处理
        ini_set('display_errors', false);
        // 基本 错误处理
        set_error_handler([$this,'handlerError']);
        // 异常处理
        set_exception_handler([$this,'handlerException']);
        // 定义 最高级别错误 处理函数
        register_shutdown_function([$this,'handlerFatalError']);

        parent::start();
    }

    /**
     * 取消
     */
    public function unRegister()
    {
        // 恢复
        restore_error_handler();
        restore_exception_handler();
    }


    /**
     * 错误处理
     *
     * @param $code
     * @param $message
     * @param $file
     * @param $line
     * @return bool
     * @throws ErrorException
     */
    public function handlerError ( $code , $message , $file , $line )
    {
        if( !class_exists('tuzhi\base\ErrorException',false) ){
            require_once( __DIR__ ."/ErrorException.php");
        }

        // 检查是否允许处理
        if( error_reporting() & $code ){

            $exception = new ErrorException($message ,$code,$code ,$file ,$line);

            throw $exception;
        }
        return false;
    }

    /**
     * 异常处理
     * @param $exception
     */
    public function handlerException( $exception )
    {

        $this->exception = $exception;

        // 禁止 递归捕获
        $this->unRegister();

        try{

            $this->clearOutput();
            $this->renderException( $exception );

        }catch( \Exception $e ){
            $msg  = "异常处理时发生另外一个错误\n";
            $msg .= (string) $e;
            $msg .= "\n处理异常为:\n";
            $msg .= (string) $exception;

            error_log($msg);
            //处理显示
            echo $msg;

            exit(1);
        }
        $this->exception = null;
    }


    /**
     * php Fatal
     */
    public function handlerFatalError()
    {
        if( !class_exists('tuzhi\base\ErrorException',false) ){
            require_once( __DIR__ ."/ErrorException.php");
        }

        $error = error_get_last();

        if( ErrorException::isFatalError($error) ){

            $exception = new ErrorException($error['message'],$error['type'] ,$error['type'] ,$error['file'] ,$error['line']);

            $this->clearOutput();
            $this->renderException($exception);

            exit(1);
        }

    }



    /**
     * 清空所有缓冲区的内容
     */
    public function clearOutput()
    {
        for($level = ob_get_level() ; $level > 0 ;$level-- ){
            if( ! @ob_end_clean() ){
                 ob_clean();
            }
        }
        return true;
    }

    /**
     * 抽象方法  输出异常
     *
     * @param $exception
     * @return mixed
     */
    abstract protected function renderException( $exception );
}