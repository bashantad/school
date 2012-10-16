<?php

class Admin_SchoolfeeController extends Zend_Controller_Action {

   public function init() {
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }

    public function indexAction() {
        $studentfeeModel = new Admin_Model_Schoolfee();
        $this->view->result = $studentfeeModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_SchoolfeeForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["fee_type_id"]);
                try {
                    $schoolfeeModel = new Admin_Model_Schoolfee();
                    $schoolfeeModel->add($formData);
                    $this->_helper->FlashMessenger->addMessage(array("edit" => "Successfully Fee Added"));
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_SchoolfeeForm();
        $form->submit->setLabel("Save");
        $schoolfeeModel = new Admin_Model_Schoolfee();
        $id = $this->_getParam('id', 0);
        $data = $schoolfeeModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();
                    $id = $formData['fee_type_id'];
                    unset($formData['fee_type_id']);
                    unset($formData['submit']);
                    $schoolfeeModel->update($formData, $id);
                    $this->_helper->FlashMessenger->addMessage(array("edit" => "Successfully Fee Edited"));
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
             $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $schoolfeeModel = new Admin_Model_Schoolfee();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $schoolfeeModel->delete($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

}

