<?php

class Admin_Model_Resultdetail {

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
            $this->setDbTable('Admin_Model_DbTable_Resultdetail');
        }
        return $this->_dbTable;
    }

    public function getAll() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(array("ur" => "school_result_detail"), array("ur.*"))
                ->joinLeft(array("k" => "school_result_detail"), "ur.result_id=k.result_id", array("k.student_id as result_student"))
                ->joinLeft(array("k" => "school_subjects"), "ur.subject_id=k.subject_id", array("k.name as subject_name"))
                ->where("ur.del='N'");
        $results = $db->fetchAll($select);
        return $results;
    }

    public function add($formData) {
        $lastId = $this->getDbTable()->insert($formData);
        var_dump($formData);
        if (!$lastId) {
            throw new Exception("Couldn't insert data into database");
        }
        return $lastId;
    }

    public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("result_dtl_id='$id'");
        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }

    public function update($formData, $id) {
        $this->getDbTable()->update($formData, "result_dtl_id='$id'");
    }

    public function delete($id) {
        $data["del"] = "Y";
        try {
            $this->getDbTable()->update($data, "result_dtl_id='$id'");
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

}

?>