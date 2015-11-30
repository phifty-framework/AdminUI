<?php
namespace AdminUI;
use Phifty\Region;

abstract class CRUDHandler extends \CRUD\CRUDHandler 
{
    public $defaultViewClass = 'AdminUI\\View';
    public $actionViewClass = 'AdminUI\\Action\\View\\StackView';


    protected $loginUrl = '/bs/login';

    protected function reportRequireLogin()
    {
        if (isset($_REQUEST['__action'])) {
            return json_encode(['error' => true, 'message' => '請重新登入', 'redirect' => $this->loginUrl]);
        }
        return $this->redirect($this->loginUrl . '?' . http_build_query(array('f' => $_SERVER['PATH_INFO'] )));
    }

    protected function reportPermissionDenied()
    {
        if (isset($_REQUEST['__action'])) {
            return json_encode([ 'error' => true, 'message' => '權限不足' ]);
        }
        return [403, ['Content-Type: text/html;'], '權限不足'];
    }

    public function prepare()
    {
        # check permission
        $currentUser = kernel()->currentUser;
        if (! $currentUser->hasLoggedIn()) {
            return $this->reportRequireLogin();
        }
        if (!$currentUser->isAdmin() && $this->resourceId && false == kernel()->accessControl->can('view', $this->resourceId)) {
            return $this->reportPermissionDenied();
        }
    }
}
