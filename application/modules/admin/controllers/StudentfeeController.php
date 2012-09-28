<?php

class Admin_StudentfeeController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $studentfeeModel = new Admin_Model_Studentfee();
        $this->view->result = $studentfeeModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_StudentfeeForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["fee_id"]);
                try {
                    $studentfeeModel = new Admin_Model_Studentfee();
                    $studentfeeModel->add($formData);
                    $this->_helper->FlashMessenger->addMessage(array("edit" => "Successfully Fee Added"));
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_StudentfeeForm();
        $form->submit->setLabel("Save");
        $studentfeeModel = new Admin_Model_Studentfee();
        $id = $this->_getParam('id', 0);
        $data = $studentfeeModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();
                    $id = $formData['fee_id'];
                    unset($formData['fee_id']);
                    unset($formData['submit']);

                    $studentfeeModel->update($formData, $id);
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
        $studentfeeModel = new Admin_Model_Studentfee();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $studentfeeModel->delete($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

}

