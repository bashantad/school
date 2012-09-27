<?php

class Admin_Form_SubjectForm extends Zend_Form {

    public function init() {

        $subjectID = new Zend_Form_Element_Hidden("subject_id");

        $grade = new Zend_Form_Element_Text("grade");
        $grade->setLabel("Grade")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $name = new Zend_Form_Element_Text("name");
        $name->setLabel("Name")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $subjectID,
            $grade,
            $name,
            $submit));
    }

}
