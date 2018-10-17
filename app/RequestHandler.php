<?php
// Class handler of all requests to the application

define("LOAD_TYPE", "request-handler");
include "../autoload.php";
include "../library/WorkerWidget.php";

class RequestHandler extends BaseObject{
	function __construct($action){
		Session::start();
		global $config;
		// check get and post requests
		if($this->is_safe($config, "..")){
			$ajaxHandler = new AjaxHandler($config);
			switch($action){
				case 'show_more_workers':
				    echo json_encode(array($ajaxHandler->show_more_workers(), $ajaxHandler->is_more($_GET['type'])));
					break;
				case 'sort_workers':
					echo json_encode(array($ajaxHandler->sort(), $ajaxHandler->is_more($_GET['type'])));
					break;
				case 'search':
					echo json_encode(array($ajaxHandler->search(), $ajaxHandler->is_more($_GET['type'])));
					break;
				case 'is_more':
					echo $ajaxHandler->is_more($_GET['type']);
					break;
				case 'show_subordinates':
					echo $ajaxHandler->getSubordinates($_POST['worker_id']);
					break;
				case 'checkLogin':
					echo $ajaxHandler->checkNewLogin($_POST['login']);
					break;
				case 'registration':
					$user = new User($config['db']);
					$user->registration();
					exit("<meta http-equiv='refresh' content='0; url= /'>");
				case 'login':
					$user = new User($config['db']);
					$user->login();
					$refresh = ($_SESSION['login-status'] == "fail")? "/login_fail" : "/";
					exit("<meta http-equiv='refresh' content='0; url= {$refresh}'>");
					break;
				case 'logout':
					$user = new User($config['db']);
					$user->logout();
					exit("<meta http-equiv='refresh' content='0; url= /'>");
					break;
				case 'update_worker':
					$worker = new Worker("", $config['db']);
					$worker->updateWorker();
					break;
				case 'create_worker':
					$worker = new Worker("", $config['db']);
					$worker->createWorker();
					break;
				case 'delete_worker':
					$worker = new Worker("", $config['db']);
					$worker->deleteWorker();
					break;
				default:
					break;
			} 
		}
		// if post or get request are unsafe
		else{
			exit("<meta http-equiv='refresh' content='0; url= /bad_request'>");
		}
	}
}
if(isset($_GET['action'])) $request = new RequestHandler($_GET['action']);
?>