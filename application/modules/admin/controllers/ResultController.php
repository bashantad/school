<?php

class Admin_ResultController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $resultModel = new Admin_Model_Result();
        $this->view->result = $resultModel->getAll();
    }

}

