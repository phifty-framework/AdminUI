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
        if (isset($config['MenuStyle']) && ! isset($config['MenuTemplate'])) {
            if ( $config['MenuStyle'] === "aim" ) {
                $config['MenuTemplate'] = '@AdminUI/aim_menu.html';
            } elseif ( $config['MenuStyle'] === "quickbox" ) {
                $config['MenuTemplate'] = '@AdminUI/quickbox.html';
            } elseif ( $config['MenuStyle'] === "standard" ) {
                $config['MenuTemplate'] = '@AdminUI/standard_menu.html';
            }
        }
        parent::setConfig($config);
    }

    public function defaultConfig()
    {
        return array(
            'MenuStyle' => 'aim', // "standard" or "aim"
        );
    }


    /**
     * Return UI related assets
     */
    public function assets()
    {
        return array(
            // 'bootstrap',
            'blueprint-light',
            'jquery-bsm-select-js',
            'jquery-collapse-7ea0f00',
            'jquery-menu-aim',
            'facebox',
            'lightbox2',
            // 'ckeditor',
            'jcrop',
            'chosen',
            'holder',
            'modal-manager',
            'adminui',
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

    public function getBasePageTemplate()
    {
        return $this->config('BasePageTemplate') ?: '@AdminUI/page.html';
    }

    public function getLoginPageTemplate()
    {
        return $this->config('LoginPageTemplate') ?: '@AdminUI/login.html';
    }

    /**
     * NOTE: The getMenu should be trigger in view,
     */
    public function getMenu()
    {
        if ($this->menu) {
            return $this->menu;
        }

        $this->menu = new Menu;
        kernel()->event->trigger('adminui.init_menu', $this->menu);

        // sort the menu
        //$this->menu->sortMenuFoldersToTop();
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
