<?php

class Admin_Form_ResultaddForm extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $subjectOption = array('English' => 'english', 'Mathematics' => 'mathenmatics');
        $examTypeOptions = array('First' => 'first', 'Second' => 'second');
        //resultID
        $resultID = new Zend_Form_Element_Hidden("result_id");
        //resultDetailID
        $resultDetailID = new Zend_Form_Element_Hidden("student_detail_id");

        //subject
        $subject = new Zend_Form_Element_Select("subject");
        $subject->setLabel("Subject")
                ->addMultiOptions($subjectOption)
                ->setAttribs(array('class' => 'feilds-sd', 'id' => 'marital'));
        //exam type
        $examType = new Zend_Form_Element_Select("exam_type");
        $examType->setLabel("Exam Type")
                ->addMultiOptions($examTypeOptions)
                ->setAttribs(array('class' => 'feilds-sd', 'id' => 'marital'));
        //marks 
        $marks = new Zend_Form_Element_Text("marks");
        $marks->setLabel("Marks")
                ->setAttribs(array('class' => 'fields-sd', 'id' => 'marital'));

        //add
        $add = new Zend_Form_Element_Submit("add");
        $formElements = array(
            $resultID,
            $resultDetailID,
            $subject,
            $examType,
            $marks,
            $add);
        $this->addElements($formElements);
        $this->setElementDecorators(array(
            'viewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-item')),
            array('Label', array('tag' => 'div')),
        ));
        $subject->removeDecorator("label");
        $examType->removeDecorator("label");
        $marks->removeDecorator("label");
        $add->removeDecorator("label");
    }

}
?>