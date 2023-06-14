<?php 

namespace Smartedutech\Littlemvc\mvc;

//use lib\mvc\Controlurl;
//include dirname(__FILE__)."/Controlurl.php";


class  Application
{
    protected static $Instance;
    public static $Module="";
    public static $Controller="";
    public $test;
    protected $param;
    public function __construct()
    {
        if(self::$Instance){
           return self::$Instance;
        }else{
            self::$Instance=$this;
        }
    }
    public function _getRequest($paramname,$default=""){

        return (isset($_REQUEST[$paramname]) && !empty($_REQUEST[$paramname]))  ? $_REQUEST[$paramname]: $default;

    }
    public function Run(){
        include dirname(__FILE__)."/../../config/routes.php";
        global $_Routes;
        $activity=$this->_getRequest("activity","inscription");

        try{

                if(isset($_Routes[$activity])){
                    $viewname=$_Routes[$activity]['Action'];
                    $Controllername=$_Routes[$activity]['Controller'];
                    $Module=$_Routes[$activity]['Module'];
                    self::$Controller=$Controllername;
                    self::$Module=$Module;

                    ///gestion des droits utilisateur
                    $hasrole=false;
                    if(isset($_Routes[$activity]['Roles']) && count($_Routes[$activity]['Roles'])>0){
                        @ session_start();
                        foreach($_Routes[$activity]['Roles'] as $role){
                            if($_SESSION['ROLE']==$role){
                                $hasrole=true;
                            }
                        }
                    } else{
                        $hasrole=true;
                    }
                    if(!$hasrole){
                        header('Location: index.php?activity=login');
                    }
                    if(!file_exists(dirname(__FILE__).'/../../blocapp/modules/'.$Module.'/Controllers/'.$Controllername.'.php')){

                        throw new \Exception("Pas de Controlleur qui correspond à l'activity : $activity");
                        die();
                    }
                     // echo dirname(__FILE__).'/../../blocapp/modules/'.$Module.'/Controllers/'.$Controllername.'.php';
                    //include_once dirname(__FILE__).'/../../blocapp/modules/'.$Module.'/Controllers/'.$Controllername.'.php';
                    $classname="blocapp\\modules\\".$Module."\\Controllers\\".$Controllername;

                    $loadobj=new $classname;//__autoload()

                    $loadobj->{$viewname}();
                }elseif(empty($activity)) {
                    if(!file_exists(dirname(__FILE__).'/../../blocapp/modules/default/Controllers/index.php')){
                        throw new \Exception("Pas de Controlleur qui correspond à l'activity : index");
                        die();
                    }

                    include_once dirname(__FILE__).'/../../blocapp/modules/default/Controllers/index.php';

                    $loadobj=new  index();//__autoload()
                    $loadobj->Acceuil();
                }else{
                     throw new \Exception("La fonctionaliter demander n'existe pas : $activity");
                     die();
                }
            }catch (\Exception $e){
                die($e->getMessage());
            }

    }
}
