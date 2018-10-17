 <?php
class Page extends BaseObject{
	public $name;
	public $params;
	function __construct($name, $config){
		Session::start();
		$this->name = (isset($_SESSION['user']) or $name == "index" or $name == "login_fail" or $name == "bad_request")? $name : "access_denied";
		$this->db = $config['db'];
		$this->language = $config['language'];
		$this->charset = $config['charset'];
		$this->app_name = $config['app_name'];
		$this->displayLimit = $config['display_limit'];
	}
	// remember the additional parameters necessary for the page formation
	public function createParams(){
		switch($this->name){
			case 'index':
				if(isset($_COOKIE['topRankWorkers1'])){
					$this->topRankWorkers = $_COOKIE['topRankWorkers'];
				}
				else{ 
					$workers = Helper::select($this->db, "SELECT id, first_name, last_name, father_name, post, chief_id FROM workers WHERE chief_id = 0");
					setcookie('topRankWorkers', $workers, time()+60); 
					$this->topRankWorkers = $workers;
				}
				break;
			case 'workers':
				if(isset($_COOKIE['workers_list'])){
					$workers = $_COOKIE['workers_list'];
				}
				else{ 
					$workers = Helper::select($this->db, "SELECT * FROM workers LIMIT $this->displayLimit");
					setcookie('workers_list', $workers, time()+60); 
				}
				$_SESSION['workers_page']['show_more_type'] = "normal";
				$_SESSION['workers_page']['displayed_workers'] = $this->displayLimit;
				$this->params = compact('workers');
				break;
			case 'workers/view':
			case 'workers/update':
				$id = $_GET['id']; 
				$worker = Helper::select($this->db, "SELECT * FROM workers WHERE '$id' = id", 1);
				$posts = Helper::select($this->db, "SELECT post FROM hierarchy");
				$this->params = compact('worker', 'chief', 'posts');
				break;
			case 'workers/create':
				$posts = Helper::select($this->db, "SELECT post FROM hierarchy");
				$this->params = compact('posts');
				break;
			case 'login_fail':
			case 'bad_request':
			case 'access_denied':
				break;
			default:
				$this->name = "not_found";
				break;
		}
	}
	// render page using added params
	public function render($dir = ""){
		$page_content = $this->fileToVar($dir."/views/{$this->name}.php", $this->params); 
		$charset = $this->charset;
		$language = $this->language;
		$app_name = $this->app_name; 
		include $dir."/views/layout.php"; 
	}
}
?>