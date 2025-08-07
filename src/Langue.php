<?php
 

namespace Smartedutech\Littlemvc;
use Smartedutech\Littlemvc\mvc\Application;
use Smartedutech\Littlemvc\mvc\Configuration;

abstract class Langue
{

 

    public static function getString($Name,$_Lang=""){
      //echo configuration::$_config['lang'];
        $lang= !empty($_Lang) ? $_Lang : configuration::$_config['lang'];
        if(file_exists(__APP_PATH__."/blocapp/modules/".Application::$Module."/Lang/".$lang.".php")){
          include (__APP_PATH__."/blocapp/modules/".Application::$Module."/Lang/".$lang.".php");
            return isset($_Lang[$Name]) ? $_Lang[$Name] : $Name;
        }else{
          //include (__APP_PATH__."/blocapp/modules/".Application::$Module."/Lang/".$lang.".php");
            return $Name;
        }
    }
    public static function getLangLayout($Name,$_Lang=""){
       //echo configuration::$_config['lang']; 
       $layout=Utils::FileNameAppele();
        if(empty($layout)){ return $Name;}
        $lang= !empty($_Lang) ? $_Lang : configuration::$_config['lang'];
        if(file_exists(__APP_PATH__."/blocapp/modules/view/Lang/".$layout."/".$lang.".php")){
          include (__APP_PATH__."/blocapp/modules/".Application::$Module."/Lang/".$lang.".php");
            return isset($_Lang[$Name]) ? $_Lang[$Name] : $Name;
        }else{
          //include (__APP_PATH__."/blocapp/modules/".Application::$Module."/Lang/".$lang.".php");
            return $Name;
        }
    }
}
