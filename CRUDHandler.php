<?php
namespace AdminUI;
use Phifty\Region;

abstract class CRUDHandler extends \CRUD\CRUDHandler 
{
    public $defaultViewClass = 'AdminUI\\View';
    public $actionViewClass = 'AdminUI\\Action\\View\\StackView';

    protected $loginUrl = '/bs/login';

    protected $loginModalUrl = '/bs/login-modal';

    protected function isXmlHttpRequest()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

    protected function reportLoginRequired()
    {
        if ($this->isXmlHttpRequest() || isset($_REQUEST['__action']))
        {
            return $this->toJson([
                'error'           => true,
                'message'         => '請重新登入',
                'login_required'  => $this->loginUrl,
                'login_modal_url' => $this->loginModalUrl,
                'redirect'        => $this->loginUrl,
            ]);
        }
        return $this->redirect($this->loginUrl . '?' . http_build_query(array('f' => $_SERVER['PATH_INFO'] )));
    }

    protected function reportPermissionDenied()
    {
        if ($this->isXmlHttpRequest() || isset($_REQUEST['__action'])) {
            return json_encode([
                'error'             => true,
                'message'           => '權限不足',
                'permission_denied' => true,
            ]);
        }
        return [403, ['Content-Type: text/html;'], '權限不足'];
    }

    public function prepare()
    {
        # check permission
        $currentUser = kernel()->currentUser;
        if (! $currentUser->hasLoggedIn()) {
            return $this->reportLoginRequired();
        }
    }
}
