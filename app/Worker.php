<?php
class Worker extends BaseObject{
	public $first_name;
	public $last_name;
	public $father_name;
	public $post;
	public $employment_start;
	public $salary;
	public $chief_id;
	public $avatar;
	public $sex;

	function __construct($post = "", $db = ""){
		$this->post = $post;
		$this->db = $db;
	}
	public function updateWorker(){
		$params = $_POST; 
        $table_name = "workers";

        // save user avatar
        Image::saveImages($params);

        foreach($params as $key => $value){
            $sql_body .= $key." = "."'".$value."',";
        }
        $sql = "UPDATE ".$table_name." SET ".substr($sql_body, 0, strlen($sql_body)-1)." WHERE id = ".$params['id'];
        mysqli_query($this->db, $sql);
        
		$refresh = "/workers/view/".$params['id'];
		exit("<meta http-equiv='refresh' content='0; url= {$refresh}'>");
	}
	public function createWorker(){
		$params = $_POST; 
        $table_name = "workers";

        Image::saveImages($params);
        if(!$params['avatar']){
        	$params['avatar'] = "default.png";
        }

        $keys = "(".implode(",", array_keys($params)).")";
        $values = "('".implode("','", array_values($params))."')";
        $sql = "INSERT INTO {$table_name} {$keys} VALUES {$values}";
        mysqli_query($this->db, $sql);

        $refresh = "/workers/view/".mysqli_insert_id($this->db);
        exit("<meta http-equiv='refresh' content='0; url= {$refresh}'>");
	}
	public function deleteWorker(){
		mysqli_query($this->db, "DELETE FROM workers WHERE id = {$_GET['id']}");
		exit("<meta http-equiv='refresh' content='0; url= /workers'>");
	}
}
?>