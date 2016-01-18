<?php
namespace AdminUI\Controller;
use Phifty\Bundle;
use Phifty\Controller;
use AdminUI\AdminUI;

class BaseController extends Controller
{
    public $defaultViewClass = 'AdminUI\\View';

    protected $requiredRole = 'admin';

    public function prepare()
    {
        // check user permission
        $cUser = kernel()->currentUser;
        if (! $cUser->hasLoggedIn() && ! $cUser->hasRole($this->requiredRole)) {
            return $this->redirect('/bs/login?' . http_build_query(array('f' => $_SERVER['PATH_INFO'] )));
        }
    }

    // render dashboard here
    public function indexAction()
    {
        $bundle = AdminUI::getInstance();
        $pageTemplate = $bundle->getBasePageTemplate();
        return $this->render($pageTemplate);
    }
}
