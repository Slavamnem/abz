<?php
class FillWorkers{
	public $db;
	public $first_names;
	public $last_names;
	public $father_names;
	public $structure = array();
	
	function __construct(){
		global $config;
		$this->db = $config['db'];
	}
	// remember company hierarhy in convenient form
	public function run(array $structure){
		$i = 0;
		$previous_segment_end = 0;
		$total = 0;
		foreach ($structure as $key => $value) {
			$this->structure[$key]['number'] = $i;
			$this->structure[$key]['count'] = $value['count'];
			$this->structure[$key]['salary'] = $value['salary'];
			$this->structure[$key]['segment-start'] = ($i > 0)? $previous_segment_end + 1 : 1;
			$this->structure[$key]['segment-end'] = $this->structure[$key]['segment-start'] + $this->structure[$key]['count'] - 1;
			$i++;
			$previous_segment_end = $this->structure[$key]['segment-end']; 
			$total += $value['count'];
		}
		$this->fill($total);
	}
	// fill the workers's table depending on parameters
	public function fill($count){
		$count_workers = Helper::select($this->db, "SELECT COUNT(id) FROM workers", 2);
		// We fill in table only if it is empty, because this function is intended for the initial filling of workers's table.
		if($count_workers == 0){
			$this->createHierarchy();
			$this->loadFIO();
			$query = "INSERT INTO workers VALUES";
			for($i = 1; $i <= $count; $i++){
				$cur_worker = $this->buildWorker($i);
				$cur_line = "('','$cur_worker->first_name','$cur_worker->last_name','$cur_worker->father_name','$cur_worker->post','$cur_worker->employment_start','$cur_worker->salary','$cur_worker->chief_id', '$cur_worker->avatar'),";
				$query .= $cur_line;
			}
			$query = substr($query, 0, strlen($query)-1);
			mysqli_query($this->db, $query); 
		}
	}
	public function truncateWorkersTable(){
		mysqli_query($this->db, "TRUNCATE TABLE workers");
	}
	public function buildWorker($counter){ 
		foreach ($this->structure as $key => $value) {
			if(($value['segment-start'] <= $counter) && ($counter <= $value['segment-end'])) {
				$worker = new Worker($key);
			}
		}
		$worker = $this->getFIO($worker, $counter);
		$worker->salary = $this->getSalary($worker->post);
		$worker->employment_start = $this->getRandomTime();
		$worker->chief_id = $this->getChiefId($worker->post);
		$worker->avatar = "default.png";
		return $worker;
	}
	// We form the name of the worker, randomly choosing his gender.
	public function getFIO(Worker $worker, $counter){
		$worker->sex = (rand(0,1))? "Male" : "Female";
		$worker->first_name = $this->first_names[$worker->sex][mt_rand(0, count($this->first_names[$worker->sex])-1)]['value'];
		$worker->last_name = $this->last_names[$worker->sex][mt_rand(0, count($this->last_names[$worker->sex])-1)]['value'];
		$worker->father_name = $this->father_names[$worker->sex][mt_rand(0, count($this->father_names[$worker->sex])-1)]['value'];
		return $worker;
	}
	// We give salary depending on worker post.
	public function getSalary($post){ 
		return $this->structure[$post]['salary'];
	}
	// choose employment_start randomomly
	public function getRandomTime(){
		$month = mt_rand(1, 12);
		$month = ($month < 10)? "0".$month : $month;
		$day = mt_rand(1, $this->getMonthDaysCount($month));
		$day = ($day < 10)? "0".$day : $day;
		return mt_rand(2000, 2018)."-".$month."-".$day;
	}

	public function getMonthDaysCount($month){
		$MonthDays = array("01"=>31, "02"=>28, "03"=>31, "04"=>30, "05"=>31, "06"=>30, "07"=>31, "08"=>31, "09"=>30, "10"=>31, "11"=>30, "12"=>31);
		return $MonthDays[$month];
	}
	// We select chief id for the worker, chief is always one rank higher.
	public function getChiefId($post){ 
		foreach($this->structure as $key => $value){
			if($value['number'] == $this->structure[$post]['number'] - 1){
				return mt_rand($value['segment-start'], $value['segment-end']);
			}
		}
		return 0;
	}
	// Remember the hierarchy in the company
	public function createHierarchy(){
		mysqli_query($this->db, "TRUNCATE TABLE hierarchy");
		
		$insert_sql = "INSERT INTO hierarchy VALUES";
		foreach ($this->structure as $key => $value) {
			$position = $value['number'] + 1;
			$rows[] = "('', '{$key}', '{$position}')";
		}
		$insert_sql = $insert_sql.implode(",", $rows);
		mysqli_query($this->db, $insert_sql);
	}
	public function loadFIO(){
		$this->first_names["Male"] = Helper::select($this->db, "SELECT value FROM first_name WHERE gender = 'Male'");
		$this->first_names["Female"] = Helper::select($this->db, "SELECT value FROM first_name WHERE gender = 'Female'");
		$this->last_names["Male"] = Helper::select($this->db, "SELECT value FROM last_name WHERE gender = 'Male'");
		$this->last_names["Female"] = Helper::select($this->db, "SELECT value FROM last_name WHERE gender = 'Female'");
		$this->father_names["Male"] = Helper::select($this->db, "SELECT value FROM father_name WHERE gender = 'Male'");
		$this->father_names["Female"] = Helper::select($this->db, "SELECT value FROM father_name WHERE gender = 'Female'");
	}
}
?>