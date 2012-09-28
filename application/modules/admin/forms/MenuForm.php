<?php

class Admin_Form_MenuForm extends Zend_Form {

    public function init() {

        $frontMenuID = new Zend_Form_Element_Hidden("front_menu_id");

        $menumodel = new Admin_Model_Menu();
        $option = $menumodel->getKeysAndValues();

        $title = new Zend_Form_Element_text("title");
        $title->setLabel("Title")
                ->setAttribs(array('class' => 'form-text'));

        $content = new Zend_Form_Element_Textarea("content");
        $content->setLabel("Content")
                ->setAttribs(array('rows' => 7, 'columns' => 10, 'class' => 'form-text'))
                ->setRequired(true);

        $parentMenuID = new Zend_Form_Element_Select("parent_menu_id");
        $parentMenuID->setLabel("Parent Menu")
                ->addMultiOptions($option)
                ->setAttribs(array('class' => 'form-text'))
                ->setRequired(true);

        $enteredDate = new Zend_Form_Element_Text("entered_date");
        $enteredDate->setLabel("Entered Date")
                ->setAttribs(array('size' => 30, 'class' => 'form-date'))
                ->setRequired(true);

        $updateDate = new Zend_Form_Element_Text("update_date");
        $updateDate->setLabel("Updated Date")
                ->setAttribs(array('size' => 30, 'class' => 'form-date'))
                ->setRequired(true);


        $action = new Zend_Form_Element_Text("action");
        $action->setLabel("Action")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'));


        $controller = new Zend_Form_Element_Text("controller");
        $controller->setLabel("Controller ")
                ->setAttribs(array('size' => 30, 'class' => 'form-date'));


        $module = new Zend_Form_Element_Text("module");
        $module->setLabel("Module")
                ->setAttribs(array('size' => 30, 'class' => 'form-date'));


        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $frontMenuID,
            $title,
            $content,
            $parentMenuID,
            $action,
            $controller,
            $module,
            $submit));
    }

}
?>

