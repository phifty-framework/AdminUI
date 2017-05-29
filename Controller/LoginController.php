<?php
namespace AdminUI\Controller;

use UserBundle\UserBundle;
use UserBundle\Action\Login;
use Phifty\Controller;
use AdminUI\AdminUI;
use OrgBundle\Model\Org;

class LoginController extends Controller
{
    public function indexAction()
    {
        $request = $this->getRequest();
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

    public function modalAction()
    {
        $request = $this->getRequest();
        $adminUI = AdminUI::getInstance();
        $bundle = UserBundle::getInstance();
        $action = new Login;
        $goto = $this->request->param('f'); /* get both from POST and GET */
        $loginModalTemplate = $adminUI->getLoginModalTemplate();
        return $this->render($loginModalTemplate, array(
            'goto' => $goto,
            'action' => $action,
            'Bundle' => $bundle
        ));
    }
}
