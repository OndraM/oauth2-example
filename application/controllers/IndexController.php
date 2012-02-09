<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->session = new Zend_Session_Namespace('OAUTH2');
        if (!isset($this->session->services)) {
            $this->session->services = array();
        }
    }

    public function indexAction()
    {
        // action body
    }

    /**
     * Destroy all sessions.
     */
    public function destroyAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->session->unsetAll();
    }


}

