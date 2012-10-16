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
                    $this->_helper->FlashMessenger->addMessage(array("edit" => "Successfully added fee"));
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_SchoolfeeForm(true);
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
                    $this->_helper->FlashMessenger->addMessage(array("edit" => "Successfully edited fee"));
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

    public function listAction() {
        $config = new Zend_Config_Ini(BASE_PATH . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . "grid.ini", 'production');
        $grid = Bvb_Grid::factory('Table', $config);
        $data = $this->_listdata();
        $source = new Bvb_Grid_Source_Array($data);
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        $grid->setSource($source);
        $grid->setImagesUrl("$baseUrl/grid/");
        $editColumn = new Bvb_Grid_Extra_Column();
        $editColumn->setPosition('right')->setName('Edit')->setDecorator("<a href=\"$baseUrl/admin/schoolfee/edit/id/{{fee_type_id}}\">Edit</a><input class=\"address-id\" name=\"address_id[]\" type=\"hidden\" value=\"{{fee_type_id}}\"/>");
        $deleteColumn = new Bvb_Grid_Extra_Column();
        $deleteColumn->setPosition('right')->setName('Delete')->setDecorator("<a class=\"delete-data\" href=\"$baseUrl/admin/schoolfee/delete/id/{{fee_type_id}}\">Delete</a>");
        $grid->addExtraColumns($editColumn, $deleteColumn);
        $grid->updateColumn('fee_type_id', array('hidden' => true));
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
        $menuModel = new Admin_Model_Schoolfee();
        $allMenus = $menuModel->getAll();
        $i = 0;
        foreach ($allMenus as $menu):
            $i++;
            $data = array();
            $data['sn'] = $i;
            $data['fee_type_id'] = $menu['fee_type_id'];
            $data['name'] = $menu['name'];
            $data['grade'] = $menu['grade'];
            $data['amount'] = $menu['amount'];
            $data['monthly?'] = ($menu['isMonthly'] == 'Y') ? 'Yes' : 'No';
            $menus[] = $data;
        endforeach;
        return $menus;
    }

}

