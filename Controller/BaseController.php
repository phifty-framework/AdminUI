<?php
namespace AdminUI\Controller;
use Phifty\Bundle;
use Phifty\Controller;

class BaseController extends Controller
{
    public $defaultViewClass = 'AdminUI\\View';

    public function before()
    {
        // check user permission
        $cUser = kernel()->currentUser;
        if( ! $cUser->hasLoggedIn() && ! $cUser->hasRole('admin') ) {
            $this->redirect( '/bs/login?' . http_build_query(array('f' => $_SERVER['PATH_INFO'] )) );
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
