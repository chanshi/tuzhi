<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/4/9
 * Time: 14:39
 */

namespace tuzhi\web;

use Tuzhi;

/**
 * Class ErrorHandler
 * @package tuzhi\web
 */
class ErrorHandler extends \tuzhi\base\ErrorHandler {


    /**
     * @var string
     */
    protected $view   = '&tuzhi/resource/view/error/error.php';

    /**
     * @var string
     */
    protected $layout = '&tuzhi/resource/view/layout.php';


   

    /**
     * @param $exception
     * @return mixed
     */
    protected function renderException( $exception )
    {
        http_response_code(500);
        echo $this->renderLayout(
            Tuzhi::alias($this->layout),
            $this->renderFile(
                Tuzhi::alias($this->view),
                [
                    'exception'=>$exception
                ]
            )
        );

    }

    /**
     * @param $file
     * @param $params
     * @return mixed
     */
    protected function renderFile($file ,$params)
    {
        ob_start();
        extract($params, EXTR_OVERWRITE);
        require ($file);
        $content = ob_get_contents();
        ob_clean();
        return $content;
    }

    /**
     * @param $layout
     * @param $content
     * @return mixed
     */
    protected function renderLayout( $layout ,$content )
    {
        ob_start();
        require($layout);
        $html = ob_get_contents();
        ob_clean();
        return $html;
    }


}