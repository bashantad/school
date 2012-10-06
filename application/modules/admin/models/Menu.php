<?php

class Admin_Model_Menu {

    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null === $this->_dbTable) {
            $this->setDbTable('Admin_Model_DbTable_Menu');
        }
        return $this->_dbTable;
    }

    public function listAll() {
        $allResults = array();
        $db = $this->getDbTable()->getDefaultAdapter();
        $select = $db->select();
        $select->from(array("current" => "school_menu"), array("current.*"))
                ->joinLeft(array("parent" => "school_menu"), "current.parent_menu_id=parent.menu_id", array("parent.title as upper_menu"));
        $results = $db->fetchAll($select);
        return $results;
    }

    public function getAll() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(array("m" => "school_menu"), array("m.*"))
                ->where("m.del='N'");
        $results = $db->fetchAll($select);
        return $results;
    }

    public function add($formData) {
        $formData['entered_date'] = date("Y-m-d");
        $lastId = $this->getDbTable()->insert($formData);
        var_dump($formData);
        if (!$lastId) {
            throw new Exception("Couldn't insert data into database");
        }
        return $lastId;
    }

    public function getKeysAndValues() {
        $result = $this->getDbTable()->fetchAll("del='N'");
        $options = array('' => '--Select--','0'=>'Main Menu');
        foreach ($result as $result) {
            $options[$result['menu_id']] = $result['title'];
        }
        return $options;
    }

    public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("menu_id='$id'");
        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }

    public function update($formData, $id) {
        $this->getDbTable()->update($formData, "menu_id='$id'");
    }

    public function delete($id) {
        $data["del"] = "Y";
        try {
            $this->getDbTable()->update($data, "menu_id='$id'");
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

    public function changeStatus($element_id) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $sql = "SELECT if(sh = 'Y', 'N', 'Y' ) as sh FROM school_menu WHERE menu_id ='$element_id'";
        $row = $db->fetchRow($sql);
        $data = array('sh' => $row['sh']);
        $this->getDbTable()->update($data, 'menu_id = ' . $element_id);
        return $row['sh'];
    }

}

