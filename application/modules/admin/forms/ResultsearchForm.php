<?php

class Admin_Form_ResultSearchForm extends Zend_Form {

    public function init() {
        $this->setMethod("post");
        $config = new Zend_Config_Ini(BASE_PATH . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . "class.ini", "production");
        $gradeOptions = $config->grade->toArray();
        $sectionOptions = $config->section->toArray();
        $examtypeModel = new Admin_Model_Examtype();
        $examTypeOptions = $examtypeModel->getexamType();
        $yearOption = array();
        for ($i = 2000; $i < 2020; $i++) {
            $yearOption[$i] = $i;
        }
        //year
        $year = new Zend_Form_Element_Select("year");
        $year->setLabel("Year")
                ->addMultiOptions($yearOption)
                ->setRequired(true)
                ->setAttribs(array('class' => 'form-select', 'id' => ''));
        //grade
        $grade = new Zend_Form_Element_Select("grade");
        $grade->setLabel("Grade")
                ->addMultiOptions($gradeOptions)
                ->setRequired(true)
                ->setAttribs(array('class' => 'form-select', 'id' => 'class'));
        //section
        $section = new Zend_Form_Element_Select("section");
        $section->setLabel("Section")
                ->addMultiOptions($sectionOptions)
                ->setRequired(true)
                ->setAttribs(array('class' => 'feilds-select', 'id' => ''));
        //roll no
        $rollNo = new Zend_Form_Element_Text("roll_no");
        $rollNo->setLabel("Roll No")
                ->addValidator('NotEmpty', true, array("messages" => "Roll Number can't be empty"))
                ->setAttribs(array('class' => 'feilds-text', 'id' => 'rollnumber'));
        //exam type
        $examType = new Zend_Form_Element_Select("examtype_id");
        $examType->setLabel("Exam Type")
                ->setRequired(true)
                ->setAttribs(array('class' => 'feilds-select', 'id' => 'marital'))
                ->addMultiOptions($examTypeOptions);
        $studentModel = new Admin_Model_Student();
        $studentNameOptions = $studentModel->searchAllNames();
        //student name
        $studentName = new Zend_Form_Element_Select("full_name");
        $studentName->setLabel("Students Name")
                ->setAttribs(array('class' => 'feilds-select', 'id' => 'studentsearch'))
                ->addMultiOptions($studentNameOptions);


        //submit
        $search = new Zend_Form_Element_Submit("Search");
        $formElements = array(
            $year,
            $grade,
            $section,
            $rollNo,
            $examType,
            $studentName,
            $search,
        );
        $this->addElements($formElements);
        $this->setElementDecorators(array(
            'viewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-item')),
            array('Label', array('tag' => 'div')),
        ));
        $grade->removeDecorator("label");
        $rollNo->removeDecorator("label");
        $examType->removeDecorator("label");
        $studentName->removeDecorator("label");
        $year->removeDecorator("label");
        $section->removeDecorator("label");
        $search->removeDecorator("label");
    }

}
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#DateOFBirth").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>