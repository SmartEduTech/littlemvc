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
}