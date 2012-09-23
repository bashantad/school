<?php

class Admin_Form_ResultForm extends Zend_Form {

    public function init() {

        $resultID = new Zend_Form_Element_Hidden("result_id");

        $class = new Zend_Form_ELement_Text("class");
        $class->setLabel("Class")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $percent = new Zend_Form_ELement_Text("percent");
        $percent->setLabel("Percent")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $ExamType = new Zend_Form_ELement_Text("exam_type");
        $ExamType->setLabel("Exam Type")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $remarks = new Zend_Form_Element_Text("remarks");
        $remarks > setLabel("Remarks")
                        ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                        ->setRequired(true);

        $submit = new Zend_Form_ELement_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $resultID,
            $class,
            $percent,
            $ExamType,
            $remarks,
            $submit));
    }

}

?>
