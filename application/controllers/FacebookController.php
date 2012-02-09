<?php

class FacebookController extends Zend_Controller_Action
{
    const CLIENT_ID = '341769282522679';
    const CLIENT_SECRET = '9c0d0f4de1fcacbfdff53489c58355a1';

    public function init()
    {
        $this->view->CLIENT_ID = self::CLIENT_ID;
        $this->view->CLIENT_SECRET = self::CLIENT_SECRET;

        $this->session = new Zend_Session_Namespace('OAUTH2');
        if (!isset($this->session->services)) {
            $this->session->services = array();
        }
    }

    public function indexAction()
    {
        $isAuthorized = $this->_isAuthorized();
        $this->view->isAuthorized = $isAuthorized;
    }

    public function callbackAction()
    {
        $code = $this->_getParam('code');   // see 4.1.2. of OAuth 2.0 draft 23
        $error = $this->_getParam('error'); // see 4.1.2.1. of OAuth 2.0 draft 23

        $this->view->status = false;
        if (!empty($error)) { // eg. 'access_denied' when user fails to confirm app
            return;
        }

        $token = $this->_requestToken($code);

        if ($token) {
            $this->session->services['facebook'] = $token;
            $this->view->status = true;
        } else { // error obtaining token
            $this->view->status = false;
        }

    }

    /**
     * Check whether user is already authorized
     *
     * @return boolean Authorization status
     *
     */
    protected function _isAuthorized()
    {
        if (isset($this->session->services['facebook'])) {
            return true;
        }
        return false;
    }



}

