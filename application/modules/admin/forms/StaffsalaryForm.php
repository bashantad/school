<?php

class Admin_Form_StaffsalaryForm extends Zend_Form {

    public function init() {

        $salaryid = new Zend_Form_Element_Hidden("salary_id");

        $monthlysalary = new Zend_Form_ELement_Text("monthly_salary");
        $monthlysalary->setLabel("monthly_salary")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $amount = new Zend_Form_ELement_Text("amount");
        $amount->setLabel("amount")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $due = new Zend_Form_ELement_Text("due");
        $due->setLabel("Due")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);
        
        $submit = new Zend_Form_ELement_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $salaryid,
            $monthlysalary,
            $amount,
            $due,
            $submit));
    }

}