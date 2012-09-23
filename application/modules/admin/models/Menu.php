<?php

class Admin_Model_Menu
{
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
    
    public function listAll()
    {
    	$allResults = array();
    	$db = $this->getDbTable()->getDefaultAdapter();
    	$select = $db->select();
    	$select->from(array("current"=>"school_front_menu"),array("current.*"))
    			->joinLeft(array("parent"=>"school_front_menu"),"current.parent_menu_id=parent.front_menu_id",array("parent.title as upper_menu"));
    	$results = $db->fetchAll($select);
    	return $results;
    }

}

