<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {

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

