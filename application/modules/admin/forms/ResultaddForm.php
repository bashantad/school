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
                ->setAttribs(array('class' => 'form-text', 'id' => 'marital'))
                ->setBelongsTo("students[{$index}]")
                ->setRequired(true);

        $remarks = new Zend_Form_Element_Text("remarks");
        $remarks->setLabel("Remarks")
                ->setAttribs(array("class" => "form-text"))
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
       // $examTypeOptions = $config->exam_type->toArray();
        $examtypeModel = new Admin_Model_Examtype();
        $examTypeOptions = $examtypeModel->getexamType();

        for ($index = 0; $index < $this->_param; $index++) {
            $subForm = $this->createElements($index);
            $this->addSubForms(array(
                "results[{$index}]" => $subForm
            ));
        }
        $year = new Zend_Form_Element_Hidden("year");
        $grade = new Zend_Form_Element_Hidden("grade");
        $subjectId = new Zend_Form_Element_Select("subject_id");
        $subjectId->setLabel("Subject")
                ->setAttribs(array("class" => "form-select"));
        $examType = new Zend_Form_Element_Select("examtype_id");
        $examType->setLabel("Exam Type")
                ->setAttribs(array("class" => "form-select"))
                ->addMultiOptions($examTypeOptions);

        $fullMarks = new zend_Form_Element_Text("full_marks");
        $fullMarks->setLabel("Full Marks")
                ->setAttribs(array("class" => "form-text"))
                ->setRequired(true);

        $passMarks = new zend_Form_Element_Text("pass_marks");
        $passMarks->setLabel("Pass Marks")
                ->setAttribs(array("class" => "form-text"))
                ->setRequired(true);

        $submit = new Zend_Form_Element_Submit("Search");
        $submit->setLabel("Add")
                ->setAttribs(array("id" => "signin_submit"));
        $this->addElements(array($subjectId,$examType,$year, $grade, $submit));
        $this->setElementDecorators(array(
            'viewHelper',
            'Description',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'clear input-wrapper')),
            array('Label', array()),
            array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-item'))
        ));
        $grade->setDecorators(array(
            'viewHelper',
            'Description',
            'Errors',
        ));
        $year->setDecorators(array(
            'viewHelper',
            'Description',
            'Errors',
        ));

        $submit->removeDecorator("label");
    }

}
