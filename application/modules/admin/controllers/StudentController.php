<?php

class Admin_StudentController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $studentModel = new Admin_Model_Student();
        $this->view->result = $studentModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_StudentForm();
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
?>

