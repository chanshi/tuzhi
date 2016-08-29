<?php
/**
 * Created by PhpStorm.
 * User: 吾色禅师<wuse@chanshi.me>
 * Date: 16/8/26
 * Time: 15:13
 */

namespace tuzhi\view\widget;

use tuzhi\view\Widget;

class ReadyJsWidget extends Widget
{

    public $view;

    public function __construct(array $config = [])
    {
        parent::__construct( $config );
    }

    /**
     *
     */
    public function init()
    {
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $jsBody = ob_get_clean();
        $this->view->registerJs( $jsBody );
        return null;
    }
}