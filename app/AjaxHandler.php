<?php
// Handling all agiax requests on the site
class AjaxHandler extends BaseObject{
	function __construct($config){	
		Session::start();
		$this->db = $config['db'];	
		$this->displayLimit = $config['display_limit'];	
	}
	// Implement a lazy load. The function returns the html code of all worker's subordinates.
	public function getSubordinates($worker_id){
		include "/library/WorkerWidget.php";
		$subordinates = Helper::select($this->db, "SELECT * FROM workers WHERE chief_id = '$worker_id'");
		if(count($subordinates) == 0){ 
			return "<p>Подчиненных нет.</p>"; 
		}
		foreach($subordinates as $worker){
			echo WorkerWidget::get(['type' => 'index', 'worker' => $worker]);
		}
		return $result;
	} 
	// Handle clicking the "View more" button. For the case of viewing sorting results, search results and for the initial list of employees
	public function show_more_workers(){ 
		if(Session::get('workers_page->show_more_type') == "sort_mode"){
			$field = Session::get('workers_page->sort_info->field');
			$sort_type = Session::get('workers_page->sort_info->sort_type');
			$offset = Session::get('workers_page->displayed_workers');
			$sql = $this->SortSql($field, $sort_type, $offset); 
		}
		else if(Session::get('workers_page->show_more_type') == "search_mode"){
			$search_field = Session::get('workers_page->search_info->field');
			$search_text = Session::get('workers_page->search_info->text');
			$offset = Session::get('workers_page->displayed_workers');
			$sql = $this->generateSearchQuery(compact('search_field', 'search_text', 'offset'))[0];
		}
		else{ 
			$displayed = Session::get('workers_page->displayed_workers');
			$sql = "SELECT * FROM workers LIMIT $this->displayLimit OFFSET $displayed";
		}

		$workers = Helper::select($this->db, $sql);
		$_SESSION['workers_page']['displayed_workers'] += count($workers);
		return $this->getNewWorkersHtml($workers);
	}
	// Sort workers by a given field and direction
	public function sort(){
		$sort_type = $_POST['sort_type'];
		list($field, $sort_type) = explode("-", $sort_type);
		$sql = $this->SortSql($field, $sort_type); 
		$workers = Helper::select($this->db, $sql);

		Session::set(['workers_page' => 
			[
				'show_more_type' => "sort_mode",
				'sort_info' => ['field' => $field, 'sort_type' => $sort_type],
				'displayed_workers' => count($workers),
			]
		]);

		return $this->getNewWorkersHtml($workers);
	}
	public function search(){
		$search_text = $_POST['search_text']; 
		$search_field = $_POST['search_field'];  
		$offset = 0;
		list($sql, $total_found) = $this->generateSearchQuery(compact('search_field', 'search_text', 'offset'));
		
		$workers = Helper::select($this->db, $sql);

		Session::set(['workers_page' => 
			[
				'show_more_type' => "search_mode",
				'search_info' => ['field' => $search_field, 'text'=> $search_text, 'total' => $total_found],
				'displayed_workers' => (count($workers) >= $this->displayLimit)? $this->displayLimit : count($workers)
			]
		]);

		return $this->getNewWorkersHtml($workers, 'search');
	}
	public function SortSql($field, $sort_type, $offset = null){
		if($field == "post"){
			$sql = "SELECT w.id, w.first_name, w.last_name, w.father_name, w.post, w.employment_start, w.salary, w.chief_id, w.avatar, (SELECT h.position FROM hierarchy as h WHERE h.post = w.post) as post_position FROM workers as w ORDER BY post_position $sort_type LIMIT $this->displayLimit";
		}
		else{ 
			$sql = "SELECT * FROM workers ORDER BY $field $sort_type LIMIT $this->displayLimit";
		}
		return $offset? $sql." OFFSET {$offset}" : $sql;
	}
	public function generateSearchQuery(array $params, $type = ""){
		extract($params);
		switch($search_field){
			case 'first_name':
			case 'last_name':
			case 'father_name':
			case 'post':
				$sql = "SELECT * FROM workers WHERE $search_field LIKE '%$search_text%' LIMIT $this->displayLimit OFFSET $offset";
				$total_found = Helper::select($this->db, "SELECT COUNT(id) FROM workers WHERE $search_field LIKE '%$search_text%'", 2); 
				break;
			case 'id':
			case 'employment_start':
			case 'salary':
			case 'chief_id':
				$sql = "SELECT * FROM workers WHERE $search_field = '$search_text' LIMIT $this->displayLimit OFFSET $offset";
				$total_found = Helper::select($this->db, "SELECT COUNT(id) FROM workers WHERE $search_field = '$search_text'", 2);
				break;
		}
		return [$sql, $total_found];
	}
	// return html code of all workers who fell into the result of the ajax request
	public function getNewWorkersHtml($workers, $type = ""){
		ob_start();
		if($type == "search"){
			$found = Session::get('workers_page->search_info->total');
			echo "<p>Found: {$found}</p>";
		}
		include "/library/WorkerWidget.php";
		foreach ($workers as $id => $worker){
			WorkerWidget::get(['type' => 'worker', 'worker' => $worker, 'chief' => $this->getChiefById($worker['chief_id'])]);
		}
		return ob_get_clean();
	}
	// Check whether all workers who are in the result of the request, displayed on the page and whether to show the button "Show more"
	public function is_more($type){
		if($type == "search" or Session::get('workers_page->show_more_type') == "search_mode"){
			return (Session::get('workers_page->displayed_workers') < Session::get('workers_page->search_info->total'))? 1:0;
		}
		return (Session::get('workers_page->displayed_workers') < $this->getWorkersCount())? 1 : 0;
	}
	// Check if login is busy 
	public function checkNewLogin($login){ 
		return (Helper::select($this->db, "SELECT id FROM users WHERE '$login' = login"))? 0 : 1;
	}
}
?>