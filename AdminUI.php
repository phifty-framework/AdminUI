<?php
namespace AdminUI;
use Phifty\Bundle;
use Phifty\Routing\Controller;
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

    public function setConfig(array $config)
    {
        if (isset($config['MenuStyle']) && ! isset($config['MenuTemplate'])) {
            if ( $config['MenuStyle'] === "aim" ) {
                $config['MenuTemplate'] = '@AdminUI/aim_menu.html.twig';
            } else if ( $config['MenuStyle'] === "quickbox" ) {
                $config['MenuTemplate'] = '@AdminUI/quickbox.html.twig';
            } else if ( $config['MenuStyle'] === "standard" ) {
                $config['MenuTemplate'] = '@AdminUI/standard_menu.html.twig';
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
        return [
            'jquery-menu-aim',
            'facebox',
            'lightbox2',
            // 'ckeditor',
            'jcrop',
            'adminui',
        ];
    }


    public function getMenuBar()
    {
        if ( $this->menuBar ) {
            return $this->menuBar;
        }
        $this->menuBar = new Menu;
        $this->kernel->event->trigger('adminui.init_menubar', $this->menuBar);
        return $this->menuBar;
    }

    public function getBasePageTemplate()
    {
        return $this->config('BasePageTemplate') ?: '@AdminUI/page.html.twig';
    }

    public function getLoginModalTemplate()
    {
        return $this->config('LoginModalTemplate') ?: '@AdminUI/login_modal.html.twig';
    }

    public function getLoginPageTemplate()
    {
        return $this->config('LoginPageTemplate') ?: '@AdminUI/login.html.twig';
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
        $this->kernel->event->trigger('adminui.init_menu', $this->menu);

        // sort the menu
        //$this->menu->sortMenuFoldersToTop();
        return $this->menu;
    }

    /* init method */
    public function init()
    {
        /* point to the same login action */
        if ($loginControllerClass = $this->config('LoginController')) {
            $this->route('/bs/login', $loginControllerClass);
            $this->route('/bs/login-modal', $loginControllerClass . ':modal');
        }
        if ($dashboardControllerClass = $this->config('DashboardController')) {
            $this->route('/bs', $dashboardControllerClass); // TODO: should be dashboard.
        }
    }
}
