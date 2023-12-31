<?php

 
namespace Smartedutech\Littlemvc\mvc;

abstract class Configuration{

    public static $_config=false;

    public static  function config(){
        try {
            $_pathconfig= __APP_PATH__."/config/config.ini";
            if(!file_exists($_pathconfig)){
                throw new \Exception("Erreur de fichier de configuration");
            }
            $stringconfig=file_get_contents($_pathconfig);
            $configdata = explode("\n", $stringconfig);

            $extractorconfigdata=array();

            foreach ($configdata as $data){
                $tmp = explode("=", $data);
                $extractorconfigdata[trim($tmp[0])]=isset($tmp[1]) ? trim($tmp[1]) : "";
            }
            self::$_config=$extractorconfigdata;
            //var_dump($extractorconfigdata);
        }catch (\Exception $e){
            echo $e->getMessage();
        }

    }



    static public function params(){
        if(!self::$_config){
            self::config();
        }else{
            return self::$_config;
        }
    }

}