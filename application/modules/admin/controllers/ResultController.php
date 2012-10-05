<?php

class Admin_ResultController extends Zend_Controller_Action {

    public function init() {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('studentautocomplete', 'json')
                ->initContext();
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }

    public function indexAction() {
        $form = new Admin_Form_ResultSearchForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ("Search" == $formData['Search']) {
                if ($form->isValid($formData)) {
                    unset($formData['Search']);
                    if ($formData['year'] != "" && $formData['grade'] != "" && $formData['exam_type'] != "" && $formData['roll_no'] == "") {
                        $resultModel = new Admin_Model_Result();
                        $results = $resultModel->searchAllResults($formData);
                        $subjectModel = new Admin_Model_Subject();
                        $subOptions = $subjectModel->getonlySubjects($formData['grade']);
                        $this->view->subjects = $subOptions;
//                        echo "<pre>";
//                        print_r($results);
//                        exit;
                        $this->view->searchResults = $results;
                    } elseif ($formData['roll_no'] != "" && $formData['year'] != "" && $formData['grade'] != "" && $formData['exam_type'] != "") {
                        // $formData['student_id'] = $formData['full_name'];
                        // unset($formData['full_name']);
                        $resultModel = new Admin_Model_Result();
                        $results = $resultModel->searchResultRollWise($formData);
//                         echo "<pre>";
//                        print_r($results);
//                        exit;
                        $this->view->searchoneResult = $results;
                    }
                }
            }
        }
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
            if ("Search" == $formData['Search']) {
                if ($form->isValid($formData)) {
                    unset($formData['Search']);
                    $studentModel = new Admin_Model_Student();
                    $results = $studentModel->search($formData);
                    $subjectModel = new Admin_Model_Subject();
                    $subOptions = $subjectModel->getSubjects($formData['grade']);
                    $addForm = new Admin_Form_ResultaddForm(sizeof($results));
                    $this->view->number = sizeof($results);
                    $addForm->subject_id->addMultiOptions($subOptions);
                    $addForm->grade->setValue($formData['grade']);
                    $addForm->year->setValue($formData['year']);
                    $this->view->addForm = $addForm;
                    $this->view->searchResults = $results;
                    $formData['Search'] = "Search";
                }
            }
            if ("Add" == $formData['Search']) {
                $addForm = new Admin_Form_ResultaddForm($formData['size_of_students']);
                unset($formData['size_of_students']);
                foreach ($formData as $data) {
                    $resultModel = new Admin_Model_Result();
                    if (is_array($data)) {
                        foreach ($data as $row) {
                            $arr = array();
                            unset($row['result_id']);
                            unset($formData['Search']);
                            $arr = $row;
                            $arr['grade'] = $formData['grade'];
                            $arr['subject_id'] = $formData['subject_id'];
                            $arr['exam_type'] = $formData['exam_type'];
                            $arr['full_marks'] = $formData['full_marks'];
                            $arr['pass_marks'] = $formData['pass_marks'];
                            $arr['year'] = $formData['year'];
                            $resultModel->add($arr);
                        }
                    }
                }
            }
        }
    }

    public function studentautocompleteAction() {
        $grade = $this->_getParam("id");
        if ($grade) {
            $studentModel = new Admin_Model_Student();
            $name = $studentModel->getStudentName($grade);
            $this->view->results = $studentModel->getStudentName($grade);
            $this->view->html = $this->view->render("result/studentautocomplete.phtml");
        }
    }

}

?>