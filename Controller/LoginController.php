<?php
namespace AdminUI\Controller;
use UserBundle\UserBundle;
use Phifty\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        $bundle = UserBundle::getInstance();
        $goto = $this->request->param('f'); /* get both from POST and GET */
        return $this->render( '@AdminUI/login.html' , array( 
            'goto' => $goto , 
            'Bundle' => $bundle ) );
    }
}


