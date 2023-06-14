<?php
 
namespace Smartedutech\Littlemvc\mvc;
use Smartedutech\Littlemvc\mvc\Application;
//include_once __APP_PATH__ . "/Application.php";

abstract class Controlurl
{

    static public $_class;
    static public $_method;
    static private $data;

     static public function dispatch($class,$method){
         try{

             $loadobj=new $class;//__autoload()
             $loadobj->{$method}();
         }catch (\Exception $e){
             die($e->getMessage());

         }

    }

    static  public function view($class,$method,$data=array()){
        self::$data=$data;
        include_once __APP_PATH__."/blocapp/modules/".Application::$Module."/views/".$class."/".$method.".phtml";
    }

    static public function form($formname,$data=array()){
        self::$data=$data;
        include_once __APP_PATH__."/blocapp/modules/".Application::$Module."/Forms/".$formname.".php";
    }

}