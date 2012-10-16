<?php

class Admin_Model_Schoolfee {

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
            $this->setDbTable('Admin_Model_DbTable_Schoolfee');
        }
        return $this->_dbTable;
    }

    public function getAll() {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select();
        $select->from(array("ur" => "school_fee_type"), array("ur.*"));
        $result = $db->fetchAll($select);
        return $result;
    }

    public function add($formData) {
        //var_dump($formData);exit;
        $lastId = $this->getDbTable()->insert($formData);
        if (!$lastId) {
            throw new Exception("Couldn't insert data into database");
        }
        return $lastId;
    }

    public function getDetailById($id) {
        $row = $this->getDbTable()->fetchRow("fee_type_id='$id'");
        if (!$row) {
            throw new Exception("Couldn't fetch such data");
        }
        return $row->toArray();
    }

    public function update($formData, $id) {
        $this->getDbTable()->update($formData, "fee_type_id='$id'");
    }

    public function delete($id) {
        try {
            $this->getDbTable()->delete($data, "fee_type_id='$id'");
        } catch (Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
    }

}

?>
