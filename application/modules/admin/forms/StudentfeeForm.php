<?php

class Admin_Form_ResultForm extends Zend_Form {

    public function init() {

        $feeid = new Zend_Form_Element_Hidden("fee_id");

        $feetitle = new Zend_Form_ELement_Text("fee_title");
        $feetitle->setLabel("Fee Title")
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
            $feeid,
            $feetitle,
            $amount,
            $due,
            $submit));
    }

}