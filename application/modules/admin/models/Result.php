<?php

class Admin_Model_Result {

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
            $this->setDbTable('Admin_Model_DbTable_Result');
        }
        return $this->_dbTable;
    }

    public function getAll() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(array("ur" => "school_result"), array("ur.*"))
                ->joinLeft(array("k" => "school_students"), "ur.student_id=k.student_id", array("k.full_name as result_student"))
                ->where("ur.del='N'");
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
        $options = array('' => '--Select--');
        foreach ($result as $result) {
            $options[$result['result_id']] = $result['student_id'];
        }
        return $options;
    }

     public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("result_id='$id'");
        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }

    public function update($formData, $id) {
        $this->getDbTable()->update($formData, "result_id='$id'");
    }

    public function delete($id) {
        $data["del"] = "Y";
        try {
            $this->getDbTable()->update($data, "result_id='$id'");
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

}

?>
