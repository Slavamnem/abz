<?php
class User extends BaseObject{
	function __construct($db){
		Session::start();
		$this->db = $db;
	} 
	public function registration(){
		$fields = $_POST;
		
		$salt = '$2a$07$ngrtgtgigkdrepeiksjcjjdkd';
		$fields['password'] = crypt($fields['password'], $salt);
		$fields['login'] = mysqli_real_escape_string($this->db, $fields['login']);
		
		$keys = "(".implode(",", array_keys($fields)).")";
		$values = "('".implode("','", array_values($fields))."')";
		$sql = "INSERT INTO users {$keys} VALUES {$values}";
		
		if(mysqli_query($this->db, $sql)){
			$this->setUser($fields['login']);
		}
	}
	// Use brute force defense for login
	public function login(){
		$login = mysqli_real_escape_string($this->db, $_POST['login']); 
		$password = $_POST['password']; 
		$user = Helper::select($this->db, "SELECT id, login, password FROM users WHERE '$login' = login LIMIT 1", 1);
			
		if(crypt($password, $user['password']) == $user['password']){
			$this->setUser($login);
	   		Session::set(['login-status' => "default"]);
		}
		else{ 
			Session::set(['login-status' => "fail"]);
		}
	}
	public function logout(){
		session_destroy();
	}
	public function setUser($login){
		Session::set(['user' => ['auth' => true, 'login' => $login]]);
	}
}
?>