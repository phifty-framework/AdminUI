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
        $currentUser = kernel()->currentUser;
        if ( ! $currentUser->hasLoggedIn() ) {
            // handle action permission
            if ( isset($_REQUEST['__action']) ) {
                return json_encode(array( 'error' => true, 'message' => _('權限不足，請檢查權限或重新登入') ));
            }

            // redirect full page only
            $this->redirect( '/bs/login?' . http_build_query(array(
                'f' => $_SERVER['PATH_INFO'] )) );
        }
    }

}
