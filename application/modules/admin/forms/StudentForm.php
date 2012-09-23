<?php

class Admin_Form_StudentForm extends Zend_Form {

    public function init() {

        $studentID = new Zend_Form_Element_Hidden("student_id");

        $rollno = new Zend_Form_ELement_Text("roll_no");
        $rollno->setLabel("Roll Number")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $fullname = new Zend_Form_ELement_Text("full_name");
        $fullname->setLabel("Full Name")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $email = new Zend_Form_ELement_Text("email");
        $email->setLabel("Email")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $phone = new Zend_Form_ELement_Text("phone");
        $phone->setLabel("Phone")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $guardian = new Zend_Form_Element_Text("guardian_name");
        $guardian->setLabel("Guardain")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $class = new Zend_Form_ELement_Text("class");
        $class->setLabel("class")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $section = new Zend_Form_ELement_Text("section");
        $section->setLabel("Section")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $submit = new Zend_Form_ELement_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $studentID,
            $rollno,
            $fullname,
            $email,
            $phone,
            $guardian,
            $class,
            $section,
            $submit ));
    }

}