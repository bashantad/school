<?php

class Admin_Form_ResultaddForm extends Zend_Form {

    protected $_param;

    public function __construct($param = 1) {
        $this->_param = $param;
        parent::__construct($param);
    }

    public function createElements($index) {
        $subForm = new Zend_Form_SubForm();

        //$subjectOption = array('English' => 'english', 'Mathematics' => 'mathenmatics');
        $resultId = new Zend_Form_Element_Hidden("result_id");
        $resultId->setBelongsTo("students[{$index}]");
        $studentId = new Zend_Form_Element_Hidden("student_id");
        $studentId->setAttribs(array("class" => "form-text booking-full-name"))
                ->setBelongsTo("students[{$index}]");

        $marks = new Zend_Form_Element_Text("marks");
        $marks->setLabel("Marks")
                ->setAttribs(array('class' => 'fields-sd', 'id' => 'marital'))
                ->setBelongsTo("students[{$index}]");

        $remarks = new Zend_Form_Element_Text("remarks");
        $remarks->setLabel("Remarks")
                ->setAttribs(array("class" => "form-text booking-restriction"))
                ->addValidator("Alnum")
                ->setBelongsTo("students[{$index}]");

        $formElements = array(
            $resultId,
            $studentId,
            $marks,
            $remarks);
        $subForm->setLegend("Mark Entry");
        $subForm->addElements($formElements);
        $subForm->setElementDecorators(array('viewHelper', "Errors"));
        return $subForm;
    }

    public function init() {
        $config = new Zend_Config_Ini(BASE_PATH . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . "class.ini", "production");
        $examTypeOptions = $config->exam_type->toArray();

        for ($index = 0; $index < $this->_param; $index++) {
            $subForm = $this->createElements($index);
            $this->addSubForms(array(
                "results[{$index}]" => $subForm
            ));
        }
        $grade = new Zend_Form_Element_Hidden("grade");
        $subjectId = new Zend_Form_Element_Select("subject_id");
        $subjectId->setLabel("Subject")
                ->setAttribs(array("class" => "form-text booking-email"));
        $examType = new Zend_Form_Element_Select("exam_type");
        $examType->setLabel("Exam Type")
                ->addMultiOptions($examTypeOptions);

        $submit = new Zend_Form_Element_Submit("add");
        $submit->setLabel("Add")
                ->setAttribs(array("id" => "signin_submit"));
        $this->addElements(array($subjectId, $examType,$grade, $submit));
        $this->setElementDecorators(array(
            'viewHelper',
            'Description',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'clear input-wrapper')),
            array('Label', array()),
            array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'clear booking-detail-item'))
        ));


        $submit->removeDecorator("label");
    }

}
