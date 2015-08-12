<?php
namespace AdminUI\Controller;
use UserBundle\UserBundle;
use UserBundle\Action\Login;
use Phifty\Controller;
use AdminUI\AdminUI;

class LoginController extends Controller
{
    public function indexAction()
    {
        $adminUI = AdminUI::getInstance();
        $bundle = UserBundle::getInstance();
        $action = new Login;
        $goto = $this->request->param('f'); /* get both from POST and GET */

        $loginPageTemplate = $adminUI->getLoginPageTemplate();
        return $this->render($loginPageTemplate, array( 
            'goto' => $goto,
            'action' => $action,
            'Bundle' => $bundle
        ));
    }
}


