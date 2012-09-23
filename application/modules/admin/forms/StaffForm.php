<?php

class Admin_Form_StaffForm extends Zend_Form {

    public function init() {

        $staffid = new Zend_Form_Element_Hidden("staff_id");

        $fullname = new Zend_Form_ELement_Text("fun_name");
        $fullname->setLabel("fun_name")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $phone = new Zend_Form_ELement_Text("phone");
        $phone->setLabel("phone")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $address = new Zend_Form_ELement_Text("address");
        $address->setLabel("address")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $email = new Zend_Form_ELement_Text("email");
        $email->setLabel("email")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $position = new Zend_Form_ELement_Text("position");
        $position->setLabel("position")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $submit = new Zend_Form_ELement_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $staffid,
            $fullname,
            $phone,
            $address,
            $email,
            $position,
            $submit));
    }

}