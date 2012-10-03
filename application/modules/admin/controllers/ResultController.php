<?php

class Admin_ResultController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }

    public function indexAction() {
        $resultModel = new Admin_Model_Result();
        $this->view->result = $resultModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_ResultForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["result_id"]);
                try {
                    $resultModel = new Admin_Model_Result();
                    $resultModel->add($formData);
                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully Result added"));
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_ResultForm();
        $form->submit->setLabel("Save");
        $resultModel = new Admin_Model_Result();
        $id = $this->_getParam('id', 0);
        $data = $resultModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();
                    $id = $formData['result_id'];
                    unset($formData['result_id']);
                    unset($formData['submit']);

                    $resultModel->update($formData, $id);
                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully Result edited"));
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
            $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $resultModel = new Admin_Model_Result();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $resultModel->delete($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

    public function detailAction() {
        $id = $this->_getParam("id", 0);
        $form = new Admin_Form_ResultdetailForm();
        $form->result_id->setValue($id);
        echo $form;
        echo $id;
    }

    public function searchAction() {
        $form = new Admin_Form_StudentSearchForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($formData['add'] == "Add") {
                foreach ($formData as $data) {
                    if (is_array($data)) {
                        foreach ($data as $row) {
                            $arra = array();
                            unset($row['result_id']);
                            unset($formData['add']);
                            $arr = $row;
                            $arr['grade'] = $formData['grade'];
                            $arr['subject_id'] = $formData['subject_id'];
                            $arr['exam_type'] = $formData['exam_type'];
                            $resultModel = new Admin_Model_Result();
                            $resultModel->add($arr);
                        }
                    }
                }
            }
//            echo "<pre>";
//            print_r($formData);
//            exit;
            if ("Search" == $formData['Search']) {
                unset($formData['Search']);
                $studentModel = new Admin_Model_Student();
                $results = $studentModel->search($formData);
                $subjectModel = new Admin_Model_Subject();
                $subOptions = $subjectModel->getSubjects($formData['grade']);
                $addForm = new Admin_Form_ResultaddForm(sizeof($results));
                $addForm->subject_id->addMultiOptions($subOptions);
                $addForm->grade->setValue($formData['grade']);
                $this->view->addForm = $addForm;
                $this->view->searchResults = $results;
            }
        }
    }

}

?>