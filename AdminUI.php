<?php
namespace AdminUI;
use Phifty\Bundle;
use Phifty\Controller;
use Phifty\Routing\CRUDHandler;
use AdminUI\Menu;

/*
    _('en')
    _('zh_CN')
    _('zh_TW')
    _('ja')
    _('es')
*/

class AdminUI extends Bundle
{

    /**
     * The left admin menu
     */
    public $menu;

    /**
     * The system menu bar
     */
    public $menuBar;

    public function setConfig($config)
    {
        if ( isset($config['menuStyle']) && ! isset($config['menuTemplate']) ) {
            if ( $config['menuStyle'] === "aim" ) {
                $config['menuTemplate'] = '@AdminUI/aim_menu.html';
            } elseif ( $config['menuStyle'] === "quickbox" ) {
                $config['menuTemplate'] = '@AdminUI/quickbox.html';
            } elseif ( $config['menuStyle'] === "standard" ) {
                $config['menuTemplate'] = '@AdminUI/standard_menu.html';
            }
        }
        parent::setConfig($config);
    }

    public function defaultConfig()
    {
        return array(
            'menuStyle' => 'aim', // "standard" or "aim"
        );
    }

    public function assets()
    {
        return array(
            // 'bootstrap',
            'blueprint-light',
            'jquery-ui-1.9',
            'jquery-bsm-select-js',
            'jquery-collapse-7ea0f00',
            'jquery-exif',
            'jquery-oembed',
            'jquery-menu-aim',
            'coffeekup',
            'facebox',
            'lightbox2',
            // 'ckeditor',
            'jcrop',
            'chosen',
            'crystal-icons',
            'holder',
            'formkit',
            'fivekit',
            'adminui',
            'font-awesome',
        );
    }


    public function getMenuBar()
    {
        if ( $this->menuBar ) {
            return $this->menuBar;
        }
        $this->menuBar = new Menu;
        kernel()->event->trigger('adminui.init_menubar', $this->menuBar);
        return $this->menuBar;
    }



    /**
     * NOTE: The getMenu should be trigger in view,
     */
    public function getMenu()
    {
        if ( $this->menu ) {
            return $this->menu;
        }
        $this->menu = new Menu;
        kernel()->event->trigger('adminui.init_menu', $this->menu);

        // sort the menu
        $this->menu->sortMenuFoldersToTop();
        return $this->menu;
    }

    /* init method */
    public function init()
    {
        /* point to the same login action */
        $this->route('/bs/login', '+AdminUI\Controller\LoginController' );
        $this->route('/bs',       '+AdminUI\BaseController'); // TODO: should be dashboard.
    }
}
