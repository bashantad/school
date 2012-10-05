<?php

class Admin_Form_ExamtypeForm extends Zend_Form {

    public function init() {

        /* fetching grade options from class.ini file */
        $config = new Zend_Config_Ini(BASE_PATH . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . "class.ini", "production");
        $gradeOptions = $config->grade->toArray();
        
        $examtypeID = new Zend_Form_Element_Hidden("examtype_id");

        $name = new Zend_Form_Element_Text("name");
        $name->setLabel("Name")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $full_marks = new Zend_Form_Element_Text("full_marks");
        $full_marks->setLabel("Full Marks")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $grade = new Zend_Form_Element_Select("grade");
        $grade->setLabel("Grade")
                ->setAttribs(array('class' => 'form-select'))
                ->addMultiOptions($gradeOptions)
                ->setRequired(true);

        $pass_marks = new Zend_Form_Element_Text("pass_marks");
        $pass_marks->setLabel("Pass Marks")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $examtypeID,
            $name,
            $grade,
            $full_marks,
            $pass_marks,
            $submit));
    }

}
