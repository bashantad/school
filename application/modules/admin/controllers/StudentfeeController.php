<?php

class Admin_StudentfeeController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $resultModel = new Admin_Model_Studentfee();
        $this->view->result = $resultModel->getAll();
    }

}

