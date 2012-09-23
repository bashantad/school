<?php

class Admin_Form_StaffForm extends Zend_Form {

    public function init() {

        $newsid = new Zend_Form_Element_Hidden("news_id");

        $title = new Zend_Form_ELement_Text("title");
        $title->setLabel("Title")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $content = new Zend_Form_ELement_Text("content");
        $content->setLabel("content")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $submit = new Zend_Form_ELement_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $newsid,
            $title,
            $phone,
            $content,
            $submit));
    }

}