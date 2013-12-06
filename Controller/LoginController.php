<?php
namespace AdminUI\Controller;
use Phifty\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        $bundle = \UserBundle\Main::getInstance();
        $goto = $this->request->param('f'); /* get both from POST and GET */
        return $this->render( '@AdminUI/login.html' , array( 
            'goto' => $goto , 
            'Bundle' => $bundle ) );
    }
}


