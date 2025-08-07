<?php

namespace Smartedutech\Littlemvc\Form;

defined('__DIR__TEMPLATE__') ?: define('__DIR__TEMPLATE__', dirname(__FILE__));

use Smartedutech\Littlemvc\Langue;


class  Form{

        private $_ElementsForm;
        private $form="";
        private $Actions="";
        public  $FormAttrib;

        private $_Has_Submit=false;

        public $_Decorator_Template=false;
        public $_Template_Name="";
        public function __construct($nameform,Elements $ElementForm=null,FormStructer $FormData=Null)
        {
            if(!$ElementForm){
                $this->_ElementsForm=new Elements();
            }else{
                $this->_ElementsForm=$ElementForm;
            }

            if(!$FormData){
                $this->FormAttrib=new FormStructer();
                //$this->FormAttrib->setName($nameform);
            }else{
                $this->FormAttrib=$FormData;
            }

          //  $this->FormContruction();
        }
        public function initValues($Values){
        //  print_r($Values);
            foreach ($Values as $key => $Value){
                if(isset($this->_ElementsForm->_form[$key])){
                    $this->_ElementsForm->_form[$key]->setValue($Value);
                   //echo"<pre>";  print_r($this->_ElementsForm->_form[$key]);echo"</pre>";
                }/*else{
                    throw new \Exception("Initialisation d'une valeur qui ne correspond pas à un atribut $key => $Value");
                }*/



            }

        }
        public function setDecorator_Template($Name="default"){
            if(!empty($Name)){
                $this->_Decorator_Template=true;
                $this->_Template_Name=$Name;
            }
        }

        public function getTemplateElt($EltsType){

            $elts=__DIR__TEMPLATE__."/template/".$this->_Template_Name."/".$EltsType.".temp";
            if(file_exists($elts)){
                return file_get_contents($elts);
            }else{
                throw new \Exception(" <br>getTemplateElt Erreur de template Form : ".$EltsType."<br>");
            }
            return "";
        }

        public function replaceInTemplate(RecordForm $elt){
            $Typ=$elt->getType();
             if(!empty($Typ)){
                $template=$this->getTemplateElt($Typ);
                $strElt="";
                if(!empty($template)){
//echo"<pre>";  print_r($elt);echo"</pre>";

                    $strElt=$template;
                    $strElt=str_ireplace("{type}",$elt->getType(),$strElt);
                    $strElt=str_ireplace("{name}",$elt->getName(),$strElt);
                    $strElt=str_ireplace("{id}",$elt->getId(),$strElt);
                    $strElt=str_ireplace("{label}",Langue::getString($elt->getLabel()),$strElt);
					
					$ee=Langue::getString($elt->getPholder());
					$ee=$ee ? $ee : ''; 
                    $strElt=str_ireplace("{pholder}",$ee,$strElt);
					
					$ee=$elt->getValue();
					$ee=$ee ? $ee : '';
				    $strElt=str_ireplace("{value}",$ee,$strElt);
                    
					$autre=$this->DetectOtherAttrib($elt->getOther());
                    $strElt=str_ireplace("{autre}",$autre,$strElt);
                    if($Typ=="select"){
                        $options=$this->options($elt->getList(),$elt->getValue());
                        $strElt=str_ireplace("{options}",$options,$strElt);
                    }

                }
                return $strElt;
            }
            return "Manque un element";
        }

        public function setAction($action){
            $this->FormAttrib->setAction($action);
        }

        public function setMethod($Method="Post"){
            $this->FormAttrib->setMethod($Method);
        }

        public function setOther($other){
            $this->FormAttrib->setOther($other);
        }

        public function setId($Id){
            $this->FormAttrib->setId($Id);
        }

        public function setClass($Class){
            $this->FormAttrib->setClass($Class);
        }
        public function addElement($keyData,$FormData){
               $this->_ElementsForm->addElement($keyData,$FormData);
        }



        public function FormElmentContruct(){
            if(is_array($this->_ElementsForm->_form) && count($this->_ElementsForm->_form)){
                $this->form.="<fieldset>";
                 foreach ($this->_ElementsForm->_form as $key => $elt){
                    $_InitValue="";//$this->_ElementsForm->lookForVariable($key);

                    if($this->_Decorator_Template){
                        if($elt->getType()!="submit" &&
                            $elt->getType()!="button" &&
                            $elt->getType()!="reset"
                        ){
                      //    echo"<pre style='color:red;'>";  print_r($elt);echo"</pre>";
                            $this->form.=$this->replaceInTemplate($elt,$elt->getValue());
                        }else{

                            $this->Actions.=$this->replaceInTemplate($elt,$elt->getValue());
                        }



                    }else{

                        switch ($elt->getType()){
                            case 'select':
                                $this->form.=$this->setSelect($elt,$elt->getValue());
                                break;
                            case "text":

                                $this->form.=$this->setText($elt,$elt->getValue());
                                break;
                            case "textarea":
                                $this->form.=$this->setTextarea($elt,$elt->getValue());
                                break;
                            case "submit":
                                $this->form.=$this->setSubmit($name,$id,$label);
                                break;
                            case "hidden":
                                $this->form.=$this->setHidden($elt,$elt->getValue());
                                break;

                            default:
                                $this->form.=$this->setOtherInput($elt,$elt->getValue());
                                break;
                        }
                    }
                }
                $this->form.="</fieldset>";
            }
        }
        public function setSelect(RecordForm $elt,$_InitValue){
            $class=$this->DetectClass($elt->getClass());
            $other=$this->DetectOtherAttrib($elt->getOther());

            $select="<label for=\"".$elt->getName()."\">".Langue::getString($elt->getLabel())."</label>";
            $select .="<select name=\"".$elt->getName()."\" id=\"".$elt->getId()."\" $other $class>";
            $list=$elt->getList();
            foreach ($list as $key=>$val){
                $selected = !empty($_InitValue) && $key==$_InitValue ? "Selected=\"selected\"" :"";
                $select.="<option value=\"$key\" $selected>$val</option>";
            }

            $select.="</select>";



            return $select;
        }



        public function setText(RecordForm $elt,$_InitValue){
            $class=$this->DetectClass($elt->getClass());
            $other=$this->DetectOtherAttrib($elt->getOther());

            $select="<label for=\"".$elt->getName()."\">".Langue::getString($elt->getLabel())."</label>";
            $select .="<input type=\"text\" value=\"$_InitValue\" name=\"".$elt->getName()."\" id=\"".$elt->getId()."\" $class $other>";
            return $select;
        }

        public function setHidden(RecordForm $elt,$_InitValue){
            $class=$this->DetectClass($elt->getClass());
            $other=$this->DetectOtherAttrib($elt->getOther());

            $select ="<input type=\"hidden\" value=\"$_InitValue\" name=\"".$elt->getName()."\" id=\"".$elt->getId()."\" $class $other>";
            return $select;
        }
        public function setOtherInput(RecordForm $elt,$_InitValue){

            $class=$this->DetectClass($elt->getClass());
            $other=$this->DetectOtherAttrib($elt->getOther());
            $input="<label for=\"".$elt->getName()."\">".Langue::getString($elt->getLabel())."</label>";

            $input .="<input type=\"".$elt->getType()."\" value=\"$_InitValue\" name=\"".$elt->getName()."\" id=\"".$elt->getId()."\" $class $other>";
            return $input;
        }

        public function setTextarea(RecordForm $elt,$_InitValue){
            $class=$this->DetectClass($elt->getClass());
            $other=$this->DetectOtherAttrib($elt->getOther());
            $input="<label for=\"".$elt->getName()."\">".Langue::getString($elt->getLabel())."</label>";

            $input .="<textarea type=\"text\" name=\"".$elt->getName()."\" id=\"".$elt->getId()."\" $other $class>".$_InitValue."</textarea>";
            return $input;
        }

        public function setSubmit($name,$id,$label ){

            $this->_Has_Submit=true;
            return "<input type=\"submit\" value=\"$label\" name=\"$name\" id=\"$id\" >";
        }

        private function DetectClass($options){
            $class="";
            if(is_array($options)){
                foreach ($options as $c){
                    $class.=" $c";
                }
            }else{
                $class.=" $options";
            }


            if(!empty($class)){
                $class=" class=\"$class\"";
            }
            return $class;
        }


        private function DetectOtherAttrib($options){
            $other="";

            if(is_array($options)){
                foreach ($options as $key=>$c){
                    $other.="$key=\"$c\"";
                }
            }


            return $other;
        }

        public function openTag(){
            $class=$this->FormAttrib->getClass();
            $other=$this->FormAttrib->getOther();
            return $this->FormAttrib;
            // return "<form $other $class action=\"".$this->FormAttrib->getAction()."\" method=\"".$this->FormAttrib->getMethod()."\" name=\"".$this->FormAttrib->getName()."\" class=\"".$this->FormAttrib->getClass()."\">";
        }

        public function closeTag(){
            $closeForm="";
            if(!$this->_Has_Submit){
                $closeForm=$this->setSubmit("submit","submit","Enregistrer");
            }
            $closeForm.="</form>";
            return $closeForm;
        }

        public function __toString()
        {
          $this->FormElmentContruct();
            // TODO: Implement __toString() method.
            if($this->_Decorator_Template){
                $elts=__DIR__TEMPLATE__."/template/".$this->_Template_Name."/form.temp";
                if(file_exists($elts)){
                    $formTemplate=file_get_contents($elts);
                }else{
                    throw new \Exception(" __toString Erreur de template Form : ".$elts);
                }

                    $strElt=$formTemplate;

                    $strElt=str_ireplace("{action}",$this->FormAttrib->getAction(),$strElt);
                    $strElt=str_ireplace("{method}",$this->FormAttrib->getMethod(),$strElt);
                    $autre=$this->DetectOtherAttrib($this->FormAttrib->getOther());
                    $strElt=str_ireplace("{autre}",$autre,$strElt);
                    $strElt=str_ireplace("{Titre}",$this->FormAttrib->getTitle(),$strElt);
                    $strElt=str_ireplace("{Id}",$this->FormAttrib->getId(),$strElt);
                    $strElt=str_ireplace("{form_actions}",$this->Actions,$strElt);
                    $form=$this->form;
                    $strElt=str_ireplace("{form_elements}",$form,$strElt);
                    $form=$strElt;



            }else{
                $form = $this->openTag();
                $form.=$this->form;

                $form.=$this->closeTag();
            }



            return $form;

        }

        public function options($liste,$_InitValue=""){
            $select="";
            foreach ($liste as $key=>$val){
                $selected = !empty($_InitValue) && $key==$_InitValue ? "Selected=\"selected\"" :"";
                $select.="<option value=\"$key\" $selected>$val</option>";
            }
            return $select;
        }



    }
