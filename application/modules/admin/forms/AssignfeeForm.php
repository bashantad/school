<?php

class Admin_Form_AssignfeeForm extends Zend_Form {

    protected $_param;

    public function __construct($param = 1) {
        $this->_param = $param;
        parent::__construct($param);
    }

    public function createElements($index) {
        $subForm = new Zend_Form_SubForm();
        $feeId = new Zend_Form_Element_Hidden("fee_id");
        $feeId->setBelongsTo("students[{$index}]");
        $studentId = new Zend_Form_Element_Hidden("student_id");
        $studentId->setAttribs(array("class" => "form-text"))
                ->setBelongsTo("students[{$index}]");

        $discount = new Zend_Form_Element_Text("discount");
        $discount->setLabel("Marks")
                ->setAttribs(array('class' => 'form-text', 'id' => 'marital'))
                ->setBelongsTo("students[{$index}]")
                ->setRequired(true)
                ->addValidator('float', true, array('locale' => 'en_US'))
                ->addValidator('Between', true, array('min' => 0, 'max' => '100'));

        $formElements = array(
            $feeId,
            $studentId,
            $discount);
        $subForm->setLegend("Mark Entry");
        $subForm->addElements($formElements);
        $subForm->setElementDecorators(array("viewHelper", "Description", "Errors", array()));
        return $subForm;
    }

    public function init() {
        for ($index = 0; $index < $this->_param; $index++) {
            $subForm = $this->createElements($index);
            $this->addSubForms(array(
                "results[{$index}]" => $subForm
            ));
        }
        $year = new Zend_Form_Element_Hidden("year");
        $submit = new Zend_Form_Element_Submit("Search");
        $submit->setLabel("Add")
                ->setAttribs(array("id" => "signin_submit"));
        $this->addElements(array($year, $submit));
        $this->setElementDecorators(array(
            'viewHelper',
            'Description',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'clear input-wrapper')),
            array('Label', array()),
            array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'discount-add-wrapper'))
        ));
        $year->setDecorators(array(
            'viewHelper',
            'Description',
            'Errors',
        ));
        $submit->removeDecorator("label");
    }

}
