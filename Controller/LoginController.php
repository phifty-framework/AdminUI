<?php
namespace AdminUI\Controller;
use Phifty\Controller;
use User\User;

class LoginController extends Controller
{
    public function indexAction()
    {
        $bundle = User::getInstance();
        // redirect
        $goto = $this->request->param('f'); /* get both from POST and GET */
        return $this->render( '@AdminUI/login.html' , array( 
            'goto' => $goto , 
            'Plugin' => $bundle ) );
    }
}


