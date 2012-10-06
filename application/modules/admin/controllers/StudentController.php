<?php

class Admin_StudentController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'login');
        }
    }
    public function indexAction() {
        $studentModel = new Admin_Model_Student();
        $this->view->result = $studentModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_StudentForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["student_id"]);
                try {
                    $subjectModel = new Admin_Model_Student();
                    $subjectModel->add($formData);
                    $this->_helper->FlashMessenger->addMessage(array("edit" => "Successfully Student Added"));
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_StudentForm();
        $form->submit->setLabel("Save");
        $studentModel = new Admin_Model_Student();
        $id = $this->_getParam('id', 0);
        $data = $studentModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();
                    $id = $formData['student_id'];
                    unset($formData['student_id']);
                    unset($formData['submit']);

                    $studentModel->update($formData, $id);
                    $this->_helper->FlashMessenger->addMessage(array("edit" => "Successfully Student Edited"));
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
            $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $studentModel = new Admin_Model_Student();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $studentModel->delete($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

    public function listAction() {
        $config = new Zend_Config_Ini(BASE_PATH . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . "grid.ini", 'production');
        $grid = Bvb_Grid::factory('Table', $config);
        $data = $this->_listdata();
        $source = new Bvb_Grid_Source_Array($data);
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        $grid->setSource($source);
        $grid->setImagesUrl("$baseUrl/grid/");
        $editColumn = new Bvb_Grid_Extra_Column();
        $editColumn->setPosition('right')->setName('Edit')->setDecorator("<a href=\"$baseUrl/admin/student/edit/id/{{student_id}}\">Edit</a><input class=\"address-id\" name=\"address_id[]\" type=\"hidden\" value=\"{{student_id}}\"/>");
        $detailColumn = new Bvb_Grid_Extra_Column();
        $detailColumn->setPosition('right')->setName('Detail')->setDecorator("<a href=\"$baseUrl/admin/student/detail/id/{{student_id}}\">Detail</a><input class=\"address-id\" name=\"address_id[]\" type=\"hidden\" value=\"{{student_id}}\"/>");
        $deleteColumn = new Bvb_Grid_Extra_Column();
        $deleteColumn->setPosition('right')->setName('Delete')->setDecorator("<a class=\"delete-data\" href=\"$baseUrl/admin/student/delete/id/{{student_id}}\">Delete</a>");
        $grid->addExtraColumns($detailColumn,$editColumn, $deleteColumn);
        $grid->updateColumn('student_id', array('hidden' => true));
        $grid->updateColumn('del', array('hidden' => true));
        $grid->setRecordsPerPage(20);
        $grid->setPaginationInterval(array(
            5 => 5,
            10 => 10,
            20 => 20,
            30 => 30,
            40 => 40,
            50 => 50,
            100 => 100
        ));
        $grid->setExport(array('print', 'word', 'csv', 'excel', 'pdf'));
        $this->view->grid = $grid->deploy();
    }

    public function _listdata() {
        $menus = array();
        $menuModel = new Admin_Model_Student();
        $allMenus = $menuModel->listAll();
      
        foreach ($allMenus as $menu):
            $data = array();
            $data['student_id'] = $menu['student_id'];
            $data['roll_no'] = $menu['roll_no'];
            $data['full_name'] = $menu['full_name'];
            $data['phone'] = $menu['phone'];
            $data['year'] = $menu['year'];
            $data['grade'] = $menu['grade'];
            $menus[] = $data;
        endforeach;
        return $menus;
    }

}
?>

