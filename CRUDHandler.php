<?php
namespace AdminUI;
use Phifty\Region;

abstract class CRUDHandler extends \CRUD\CRUDHandler 
{
    public $defaultViewClass = 'AdminUI\\View';
    public $actionViewClass = 'AdminUI\\Action\\View\\StackView';

    public function before()
    {
        # check permission
        $user = kernel()->currentUser;
        if( ! $user->isLogged()  ) {
            // var_dump( $user->isLogged() );
            // var_dump( $user->hasRole('admin') );
            // die();
            $this->redirect( '/bs/login?' . http_build_query(array(
                'f' => $_SERVER['PATH_INFO'] )) );
        }
    }

}
