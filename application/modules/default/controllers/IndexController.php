<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $content = explode("-",$this->_getParam("content"));
        $arr = explode("-",  base64_decode(base64_decode(base64_decode($content[1]))));
        $menuModel = new Admin_Model_Menu();
        $this->view->menu = $menuModel->getDetailById($arr[0]);
    }
    public function contactUsAction()
    {
        $this->view->config = new Zend_Config_Ini(BASE_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'class.ini','maps');
        
    }

}

