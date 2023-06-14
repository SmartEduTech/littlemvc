<?php
namespace lib\Form;
class Elements{

    public  $_form;
    public function addElement($keyForm,$Form){

        $RecordForm=new RecordForm();
        $RecordForm->setName($keyForm);
       // print_r($Form);
        $RecordForm->setLabel(isset($Form['label']) ? $Form['label'] : "");
        $RecordForm->setType(isset($Form['type']) ? $Form['type'] : "");
        $RecordForm->setList(isset($Form['list']) ? $Form['list'] : "");
        $RecordForm->setClass(isset($Form['options']['class']) ? $Form['options']['class'] : "");
        $RecordForm->setId(isset($Form['id']) ? $Form['id'] : "");
        $RecordForm->setOther(isset($Form['options']['other']) ? $Form['options']['other'] : "");
       // var_dump($RecordForm);

        $this->_form[$keyForm]=$RecordForm;
    }
    public function lookForVariable($keys){
      return  $this->_form[$keys]['value'];
    }
    public function getAffiche(){
        return true;
    }

}