<?php
	require_once("config.php");

	class MySQLDatabase {
		private $connection;
		private $magic_quotes_active;
		private $mysqli_real_escape_string_exist;

		function __construct () {
			$this->open_connection();
			$this->magic_quotes_active = get_magic_quotes_gpc();
			$this->mysqli_real_escape_string_exist=function_exists("mysqli_real_escape_string");

		}

		public function open_connection() {
			$this->connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
			if(!$this->connection) {
				die("Database Connection failed: ". mysqli_error() );
			} else {
				$db_select=mysqli_select_db($this->connection, DB_NAME);
				if(!$db_select) {
					die("Database Connection failed: ". mysqli_error() );
				}
			}
		}

		public function close_connection () {
			if(isset($this->connection)) {
				mysqli_close($this->connection);
				unset($this->connection);
			}
		}

		public function query($sql) {
			$result=mysqli_query($this->connection, $sql);
			$this->confirmQuery($result);
			return $result;
		}

		public function queryTest($sql) {
			$result=mysqli_query($this->connection, $sql);
			$this->confirmQuery($result);
			return $result;
		}


		public function escape_value($value) {
			
			if($this->mysqli_real_escape_string_exist) {
				// undo any magic quote effects so mysql_real_escape_string can do the work
				if($this->magic_quotes_active) {
					$value=stripcslashes($value);
				}
				$value=mysqli_real_escape_string($this->connection, $value);
			} else {
				// if magic quotes aren't already on then add slashes manually
				if(!$this->magic_quotes_active) {
					$value=addcslashes($value);
				}
				// if magic quotes are active, then the slashes already exists
			}
			return $value;
		}

		public function fetch_array($result_set) {
			return mysqli_fetch_assoc($result_set);
		}

		public function num_rows($result_set) {
			return mysqli_num_rows($result_set);
		}

		public function insert_id() {
			return mysqli_insert_id($this->connection);
		}

		public function affected_rows () {
			return mysqli_affected_rows($this->connection);
		}

		private function confirmQuery($result) {
			if(!$result) {
				die("Database Query Failed :" .mysqli_error($this->connection));
			}
		}
	}


	$database=new MySQLDatabase();

?>