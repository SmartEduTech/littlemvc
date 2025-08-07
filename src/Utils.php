<?php



namespace Smartedutech\Littlemvc; 
abstract class Utils{
	
	
	
	 public static function encrypt2($sData){
		$id=(double)$sData*525325.24;
		return base64_encode($id);
	}

	 public static function decrypt2($sData){
		$url_id=base64_decode($sData);
		$id=(double)$url_id/525325.24;
		return $id;
	}

	public static function page404notfound(){
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
			echo "<h1 style='text-align:center;color:red;'>Error 404 Not Found</h1><br>";
			echo "<p style='text-align:center;'><h2 style='text-align:center;'>The page that you have requested could not be found.</h2><br>";
			echo "<h2 style='text-align:center;'>La page que vous avez demandée est introuvable.</h2><br>";

			echo "<h2  style='text-align:center;'>ا يمكن العثور على الصفحة التي طلبتها.</h2><br></p>";
			return;
	}


	public static  function FileNameAppele() {
    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
    if (isset($trace[1]['file'])) {
        $filePath = $trace[1]['file'];
        return pathinfo($filePath, PATHINFO_FILENAME);
    }
    return null;
  }
}