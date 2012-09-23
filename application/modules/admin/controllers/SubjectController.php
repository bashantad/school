<?php

class Admin_SubjectController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $subjectModel = new Admin_Model_Subject();
        $this->view->result = $subjectModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_SubjectForm();
        $this->view->form = $form;
//        if ($this->getRequest()->isPost()) {
//            $formData = $this->getRequest()->getPost();
//            if ($form->isValid($formData)) {
//                unset($formData['submit']);
//                unset($formData["subject_id"]);
//                try {
//                    $subjectModel = new Admin_Model_Subject();
//                    $subjectModel->add($formData);
//                    $this->_helper->redirector('add');
//                } catch (Exception $e) {
//                    $this->view->message = $e->getMessage();
//                }
//            }
//        }
    }

}
