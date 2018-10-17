<?php
// The main class that handles incoming requests
class Application extends BaseObject{
	public $user;
	public $config;

	function __construct($config, $request_type=""){ 
		$this->user = new User();
		$this->config = $config;
		$this->db = $config['db'];
		$this->language = $config['language'];
		$this->charset = $config['charset'];
		$this->app_name = $config['app_name'];
		$this->displayLimit = $config['display_limit'];
		Session::start();

		// If this is a basic request (not ajax)
		if($request_type == "basic"){
			$this->startApp(); 
		}
	}
	// function checks incoming post and get requests, and if there are no inconsistencies forms the response page
	public function startApp(){
		if($this->is_safe($this->config, "")){
			$page = new Page($this->getPageName(), $this->config);
			$page->createParams();
			$page->render();
		}
	}
	public function getPageName(){
		$page_name = (isset($_GET['type']))? $_GET['type']."/".$_GET['alias'] : $_GET['alias'];
		if(!$page_name) $page_name = "index";
		return $page_name;
	}
}
?>