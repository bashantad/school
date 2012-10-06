<?php

class Admin_Form_ResultdetailForm extends Zend_Form {

    public function init() {

        $resultdtID = new Zend_Form_Element_Hidden("result_dtl_id");

        $resultmodel = new Admin_Model_Result();
        $option = $resultmodel->getKeysAndValues();

        $result = new Zend_Form_Element_Hidden("result_id");
        $subjectmodel = new Admin_Model_Subject();
        $options = $subjectmodel->getKeysAndValues();

        $subject = new Zend_Form_Element_Select("subject_id");
        $subject->setLabel("Subject")
                ->addMultiOptions($options)
                ->setAttribs(array('class' => 'form-select'));

        $marks = new Zend_Form_Element_Text("marks");
        $marks->setLabel("Marks")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $resultdtID,
            $result,
            $subject,
            $marks,
            $marks,
            $submit));
    }

}

?>
