<?php

class Admin_ResultdetailController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }

    public function indexAction() {
        $resultdetailModel = new Admin_Model_Resultdetail();
        $this->view->result = $resultdetailModel->getAll();
    }
    
      public function addAction() {
        $form = new Admin_Form_ResultdetailForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["result_dtl_id"]);
                try {
                    $resultdetailModel = new Admin_Model_Resultdetail();
                    $resultdetailModel->add($formData);
                    $this->_helper->FlashMessenger->addMessage(array("success"=>"Successfully Result Detail added"));
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
                }
            }
        }
    }
    
    
     public function editAction() {

        $form = new Admin_Form_ResultdetailForm();
        $form->submit->setLabel("Save");
        $resultdetailModel = new Admin_Model_Resultdetail();
        $id = $this->_getParam('id', 0);
        $data = $resultdetailModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();
                    $id = $formData['result_dtl_id'];
                    unset($formData['result_dtl_id']);
                    unset($formData['submit']);

                    $resultdetailModel->update($formData, $id);
                    $this->_helper->FlashMessenger->addMessage(array("success"=>"Successfully Result Detail edited"));
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
            $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $resultdetailModel = new Admin_Model_Resultdetail();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $resultdetailModel->delete($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

}

?>

