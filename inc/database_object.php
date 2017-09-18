<?php
	require_once("database.php");

	class DatabaseObjects {

		
 		
 		public static function find_all() {
			return static::find_by_sql("SELECT * FROM ".static::$table_name);
		}

		public static function find_by_id($id=0) {
			global $database;			
			$result_array=static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1");
			return !empty($result_array) ? array_shift($result_array) : false;
		}

		public static function find_by_sql ($sql="") {
			global $database;
			$result_set=$database->query($sql);
			$object_array=array();
			while($row=$database->fetch_array($result_set)) {
				$object_array[]=static::instantiate($row);
			}
			return $object_array;
		}

		public static function count_all() {
			global $database;
			$sql="SELECT count(*) FROM ".static::$table_name;
			$result_set=$database->query($sql);
			$row=$database->fetch_array($result_set);
			return array_shift($row);
		}

		public function attributes() {
			// return an array of attribute keys and their values
			
			$attributes=array();
			foreach (static::$db_fields as $field) {
				if(property_exists($this,$field)) {
					$attributes[$field] =$this->$field;
				}
			}

			return $attributes;
		}

		public static function instantiate($record) {
			// could check that recors exists and is an array
			// Simple, long-form approach
			$this_class=get_called_class();
			$this_object= new $this_class;


			// $this_object->id = $record['id'];
			// $this_object->email = $record['email'];
			// $this_object->password = $record['password'];
			// $this_object->first_name = $record['first_name'];
			// $this_object->last_name = $record['last_name'];

			//more dynamic, short-form approach
			foreach ($record as $attribute => $value) {
				if($this_object->has_attribute($attribute)) {
					$this_object->$attribute=$value;
				}
			}
		

			return $this_object;
		}

		private function has_attribute($attribute) {
			// get_object_vars returns an associative array with all attributes
			// (include private ones!) as the keys and their current values as the value
			$this_class=get_called_class();
			$this_object= new $this_class;
			$object_vars=get_object_vars($this_object);

			// we dont care about the value, we just want to know if the key exists will return true or false.
			return array_key_exists($attribute, $object_vars);
			
		}

		public function sanitized_attributes(){
			global $database;

			$clean_attributes = array();
			foreach ($this->attributes() as $key => $value) {
				$clean_attributes[$key] = $database->escape_value($value);
			}
			return $clean_attributes;
		}

		public function save () {
			return isset($this_object->id) ? $this->update() : $this->create();
		}


		public function create () {
			global $database;

			$attributes=$this->sanitized_attributes();
			
			$sql  = "INSERT INTO ".static::$table_name." (";
			$sql .= join(", ", array_keys($attributes));
			$sql .= ") VALUES ('";
			$sql .= join("', '", array_values($attributes));
			$sql .= "')";

			if($database->query($sql)) {
				$this->id=$database->insert_id();
				return true;
			} else {
				return false;
			}
			

		}

		public function update () {
			global $database;
			$this_class=get_called_class();
			$this_object= new $this_class;
			$attributes=$this_object->sanitized_attributes();
			$attribute_pairs =array();
			foreach ($attributes as $key => $value) {
				$attribute_pairs[]="{$key}='{$value}'";
			}

			$sql  = "UPDATE ".static::$table_name." SET ";
			$sql .= join(", ", $attribute_pairs);
			$sql .= " WHERE id=". $database->escape_value($this->id);
			$database->query($sql);
			return ($database->affected_rows() == 1) ? true : false;
		}

		public function delete() {
			global $database;

			$sql  = "DELETE FROM ".static::$table_name;
			$sql .= " WHERE id=".$database->escape_value($this->id);
			$sql .= " LIMIT 1";
			$database->query($sql);
			return ($database->affected_rows() == 1) ? true : false;
		}

		
	
 	}

?>