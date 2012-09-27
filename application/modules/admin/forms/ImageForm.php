<?php

class Admin_Form_ImageForm extends Zend_Form {

    public function init() {

        $imageID = new Zend_Form_Element_Hidden("image_id");

        $gallerymodel = new Admin_Model_Gallery();
        $option = $gallerymodel->getKeysAndValues();

        $gallery = new Zend_Form_Element_Select("gallery_id");
        $gallery->setLabel("Gallery")
                ->addMultiOptions($option)
                ->setAttribs(array('class' => 'form-select'));

        $imagename = new Zend_Form_Element_Text("image_name");
        $imagename->setLabel("Image")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $imageID,
            $gallery,
            $imagename,
            $submit));
    }

}

?>
