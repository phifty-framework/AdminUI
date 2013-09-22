<?php
namespace AdminUI;
use Phifty\Bundle;
use Phifty\Controller;

class BaseController extends Controller
{
    public $defaultViewClass = 'AdminUI\\View';

    public function before()
    {
        // check user permission
        $cUser = kernel()->currentUser;
        // if( ! $cUser->isLogged() && ! $cUser->hasRole('admin') ) {

        /*
        if( ! $cUser->isLogged() ) {
            $this->redirect( '/bs/login?' . http_build_query(array(
                'f' => $_SERVER['PATH_INFO'] )) );
        }
        */
    }

    // render dashboard here
    public function indexAction()
    {
        return $this->render( '@AdminUI/page.html');
    }
}
