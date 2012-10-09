<?php

class Admin_Model_Theme {

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
            $this->setDbTable('Admin_Model_DbTable_Theme');
        }
        return $this->_dbTable;
    }

    public function listinKeyValue() {
        $option = array();
        $results = $this->getDbTable()->fetchAll()->toArray();
        foreach ($results as $result) {
            $option[$result['theme_id']] = $result['name'];
        }
        return $option;
    }

    public function setActive($themeId) {
        $data['active'] = "N";
        $this->getDbTable()->update($data, "1");
        $data['active'] = "Y";
        $this->getDbTable()->update($data, "theme_id=" . $themeId);
    }
    public  function getActive()
    {
        $result = $this->getDbTable()->fetchRow("active='Y'");
        if(!$result){
            $name = "layout";
        }else{
            $name = $result['actual_name'];
        }
        return $name;
    }

}