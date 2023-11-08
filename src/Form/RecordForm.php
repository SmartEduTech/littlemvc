<?php
/**
 * Created by PhpStorm.
 * User: o.limam
 * Date: 09/05/2018
 * Time: 13:08
 *
 */
 /*
  "type"=>"textarea"
            ,"options"=>array(
                "class"=>array()
,"other"=>array(
        "rows"=>3
    ,"cols"=>50
    ,"value"=>""
    ,"data_Id"=>""
    )
)
            ,"name"=>"LA_Titre"
            ,"label"=>"Titre: "

*/
namespace Smartedutech\Littlemvc\Form;


class RecordForm implements Record
{

    private $_type="";
    private $_other="";
    private $_class="";
    private $_name="";
    private $_id="";
    private $_pholder="";
    private $_label="";
    private $_list;
    private $_Value="";

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_Value;
    }

    /**
     * @param mixed $Value
     */
    public function setValue($Value)
    {
        if($this->getType()=="checkbox"){
            if($Value){
                 $this->_other['checked']='checked';
            }
           
            $this->_Value = $Value;
        }elseif($this->getType()=="datetime"){
            $this->_Value = str_replace(" ","T",$Value);
           // echo $this->_Value."<br>"; 
        }else{
            $this->_Value = $Value;
        }
        
    }
    /**
     * @return mixed
     */
    public function getPholder()
    {
        return $this->_pholder;
    }

    /**
     * @param mixed $pholder
     */
    public function setPholder($pholder)
    {
        $this->_pholder = $pholder;
    }
    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->_list;
    }

    /**
     * @param mixed $list
     */
    public function setList($list)
    {
        $this->_list = $list;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->_class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->_class = $class;
    }

    /**
     * @return mixed
     */
    public function getOther()
    {
        return $this->_other;
    }

    /**
     * @param mixed $other
     */
    public function setOther($other)
    {
        $this->_other = $other;
    }

    public function setInOther($attrib,$value){
        $this->_other[$attrib] = $value;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->_label = $label;
    }

    public function ToNode(){
        $tree["key"]= $this->_id;
        $tree["title"]= $this->_name;
        $tree["tooltip"]= $this->_type.":".$this->_name;
        $tree["folder"]= "false";
        $tree["iconclass"]="fa fa-calendar";
        if(is_array($this->_other)){
            foreach ($this->_other as $key => $o){

                $bindList=[];
                $bindList["key"]= $key;
                $bindList["title"]= $key;
                $bindList["tooltip"]= $key.":".$o;
                $bindList["folder"]= "false";
                $tree['children'][]=$bindList;
                $tree["iconclass"]="fa fa-tag";
            }
        }

        return $tree;
    }

    public function toJson() {}
    public function FromJsonString(string $JsonString){

        $JsonDecode = json_decode($JsonString);
        $this->_name=isset($JsonDecode['name']) ? $JsonDecode['name'] : "";
        $this->_label=isset($JsonDecode['label']) ? $JsonDecode['label'] : "";
        $this->_id =isset($JsonDecode['id']) ? $JsonDecode['id'] : "";
        $this->_other=isset($JsonDecode['other']) ? $JsonDecode['other'] : "";
        $this->_class=isset($JsonDecode['class']) ? $JsonDecode['class'] : "";
    }

    public function FromArray($JsonDecode){
        $this->_name=isset($JsonDecode['name']) ? $JsonDecode['name'] : "";
        $this->_label=isset($JsonDecode['label']) ? $JsonDecode['label'] : "";
        $this->_id =isset($JsonDecode['id']) ? $JsonDecode['id'] : "";
        $this->_other=isset($JsonDecode['other']) ? $JsonDecode['other'] : "";
        $this->_class=isset($JsonDecode['class']) ? $JsonDecode['class'] : "";
    }

    public function HasAttribute($attribute){

    }
}