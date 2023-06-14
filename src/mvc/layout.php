<?php
 
namespace Smartedutech\Littlemvc\mvc;
class layout
{
    protected $layoutname ;
    protected $view;
    public function __construct()
    {
        $this->layoutname="layout";
    }

    public function setlayout($layoutname="layout"){
        $this->layoutname=$layoutname;
    }
    public function generate(&$view)
    {
        $this->view=$view;
        if(!file_exists(__APP_PATH__."/blocapp/views/layout/".$this->layoutname.".phtml")){
            throw new \Exception("Le fichier ".$this->layoutname." de calque de sortie n'existe pas pour ");
            die();
        }
        include_once __APP_PATH__."/blocapp/views/layout/".$this->layoutname.".phtml";

    }
}