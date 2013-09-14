<?php
namespace AdminUI;

class View extends \Phifty\View
{
    public function init()
    {
        // register variable
        $this->args['AdminUI'] = \AdminUI\AdminUI::getInstance();
    }
}

