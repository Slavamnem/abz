<?php
class Session{
	public static function start(){
		session_start();
	}
	// function to set an unlimited number of variables in a session in one step
	public static function set(array $arr){
		Session::start();
		foreach ($arr as $key => $value) {
			switch($value){
				case "":
					$_SESSION[$key] = 0;
					break;
				case "++":
					$_SESSION[$key] = $_SESSION[$key] + 1;
					break;
				case "--":
					$_SESSION[$key] = $_SESSION[$key] - 1;
					break;
				default:
					$_SESSION[$key] = $value;
					break;
			}
		}
	}
	// return session variable of any nesting level
	// example: Session::get('workers_page->sort_info->field')
	public static function get($keys){
		Session::start();
		$keys = explode("->", $keys);
		$result = $_SESSION[$keys[0]];
		for($i = 1; $i < count($keys); $i++){
			$result = $result[$keys[$i]];
		}
		return $result;
	}
}
?>