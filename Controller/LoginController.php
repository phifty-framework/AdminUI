<?php
namespace AdminUI\Controller;
use UserBundle\UserBundle;
use UserBundle\Action\Login;
use Phifty\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        $bundle = UserBundle::getInstance();
        $action = new Login;
        $goto = $this->request->param('f'); /* get both from POST and GET */
        return $this->render( '@AdminUI/login.html' , array( 
            'goto' => $goto , 
            'action' => $action,
            'Bundle' => $bundle) );
    }
}


