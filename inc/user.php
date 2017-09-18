<?php
	require_once("database.php");

	class User extends DatabaseObjects {

		protected static $table_name="users";

		// "show details from users" in future when no of attributes field is large
		protected static $db_fields= array('email','password','first_name','last_name');

		public $id;
		public $email;
		public $password;
		public $first_name;
		public $last_name;

		
		public function full_name() {
			if( isset($this->first_name) && isset($this->last_name) ) {
				return $this->first_name ." ". $this->last_name;
			} else {
				return "hey";
			}
		}


		public static function authenticate($email="", $password="") {
			global $database;
			$email=$database->escape_value($email);
			$password=$database->escape_value($password);

			$sql  = "SELECT * FROM users ";
			$sql .= "WHERE email ='{$email}' ";
			$sql .= "AND password ='{$password}' ";
			$sql .= "LIMIT 1";
			$result_array=self::find_by_sql($sql);
			return !empty($result_array) ? array_shift($result_array) : false;
		}
	
			
	}

	
?>