<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initEnvironment() {
        mb_internal_encoding('utf-8');
        date_default_timezone_set('Europe/Prague');
    }

    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
    }


}

