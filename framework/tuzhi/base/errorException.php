<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/9
 * Time: 11:23
 */

namespace tuzhi\base;


class ErrorException extends \ErrorException {


    /**
     * ErrorException constructor.
     * @param string $message
     * @param int $code
     * @param int $severity
     * @param string $filename
     * @param int $lineNo
     * @param \Exception $previous
     */
    public function __construct($message, $code = 0, $severity = 0, $filename, $lineNo, \Exception $previous =null)
    {
        parent::__construct($message, $code, $severity, $filename, $lineNo, $previous);
    }

    /**
     * @param $error
     * @return bool
     */
    public static function isFatalError($error)
    {
        return isset($error['type']) && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, self::E_HHVM_FATAL_ERROR]);
    }
    /**
     * 优化显示
     */
    public function getName()
    {

        static $names = [
            E_COMPILE_ERROR => 'PHP Compile Error',
            E_COMPILE_WARNING => 'PHP Compile Warning',
            E_CORE_ERROR => 'PHP Core Error',
            E_CORE_WARNING => 'PHP Core Warning',
            E_DEPRECATED => 'PHP Deprecated Warning',
            E_ERROR => 'PHP Fatal Error',
            E_NOTICE => 'PHP Notice',
            E_PARSE => 'PHP Parse Error',
            E_RECOVERABLE_ERROR => 'PHP Recoverable Error',
            E_STRICT => 'PHP Strict Warning',
            E_USER_DEPRECATED => 'PHP User Deprecated Warning',
            E_USER_ERROR => 'PHP User Error',
            E_USER_NOTICE => 'PHP User Notice',
            E_USER_WARNING => 'PHP User Warning',
            E_WARNING => 'PHP Warning',
            //self::E_HHVM_FATAL_ERROR => 'HHVM Fatal Error',
        ];

        return isset($names[$this->getCode()]) ? $names[$this->getCode()] : 'Error';
    }
}