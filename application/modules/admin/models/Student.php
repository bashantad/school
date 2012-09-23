<?php

class Admin_Model_Student {

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
            $this->setDbTable('Admin_Model_DbTable_Student');
        }
        return $this->_dbTable;
    }


   public function getAll() {
        $results = $this->getDbTable()->fetchAll("del='N'");
        return $results->toArray();
    }

    }

?>
