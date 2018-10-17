<?php
// base class of the application. It's properties and functions inherit most other classes
class BaseObject{
	public $db;
	public $language;
	public $charset;
	public $app_name;
	public $displayLimit;
	public $topRankWorkers;

	// Security check for incoming post and get requests
	public function is_safe($config, $dir = ""){
		foreach($_POST as $value){
			if(!$this->checkSecurity($value)){
				$page = new Page("bad_request", $config);
				$page->render($dir);
				return false;
			}
		}
		foreach($_GET as $value){
			if(!$this->checkSecurity($value)){
				$page = new Page("bad_request", $config);
				$page->render($dir);
				return false;
			}
		}
		return true;
	}
	public function checkSecurity($value){
		$denied_symbols = ["+", "?", "/", "<", ">", "$", "="];

        if($value != htmlspecialchars(strip_tags(stripslashes(trim($value))))){
        	return false;
        }
        for($i = 0; $i < strlen($value); $i++){
            if(in_array($value[$i], $denied_symbols)){
                return false;
            }
        }
        return true;
	}

	// function wraps the file into a variable
	public function fileToVar($file, $params = []){
		ob_start();
		extract($params);
	    require($file);
	    return ob_get_clean();
	}
	// Counting the total number of workers
	public function getWorkersCount(){
		return Helper::select($this->db, "SELECT COUNT(id) FROM workers", 2);
	}
	// return data about the chief of his id
	public function getChiefById($id){
		if($id == 0){ return "-"; }
		$chief = Helper::select($this->db, "SELECT first_name, last_name, father_name, post FROM workers WHERE id = $id", 1);
		return $chief['last_name']." ".$chief['first_name']." ".$chief['father_name']." (".$chief['post'].")";
	}
	// For the main page. Return html code of workers that have highest rank.
	public function getTopRankWorkersHtml(){
		include "/library/WorkerWidget.php";
		foreach ($this->topRankWorkers as $key => $worker) {
			WorkerWidget::get(['type' => 'index', 'worker' => $worker]);
		}	
	}
}
?>