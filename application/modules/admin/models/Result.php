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
                ->joinLeft(array("p" => "school_students"), "ur.student_id=p.student_id", array("p.student as result_student"))
                ->where("ur.del='N'");
        $results = $db->fetchAll($select);
        return $results;
    }
    
    

}

?>
