<?php

class Admin_FinanceController extends Zend_Controller_Action {

   public function init() {
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }

    public function listAction()
    {
        
    }

    
}

