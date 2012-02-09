<?php

class FacebookController extends Zend_Controller_Action
{
    const CLIENT_ID = '341769282522679';
    const CLIENT_SECRET = '9c0d0f4de1fcacbfdff53489c58355a1';

    public function init()
    {
        $this->view->CLIENT_ID = self::CLIENT_ID;
        $this->view->CLIENT_SECRET = self::CLIENT_SECRET;
    }

    public function indexAction()
    {
        $isAuthorized = $this->_isAuthorized();
        $this->view->isAuthorized = $isAuthorized;
    }

    /**
     * Check whether user is already authorized
     *
     * @return boolean Authorization status
     */
    protected function _isAuthorized() {
        return false;
    }



}

