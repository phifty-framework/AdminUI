<?php
namespace AdminUI;
use Phifty\Singleton;


/**
 * The Main Menu
 */
class Menu extends MenuFolder
{
    /**
     * Override the MenuFolder __construct
     */
    public function __construct()
    {
    }

    static public function getInstance()
    {
        static $ins;
        if ( $ins ) {
            return $ins;
        }
        return $ins = new self;
    }
}



