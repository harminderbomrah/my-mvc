<?php

class ModelAdapter{

	public $table;
	public $database_name;
	public $columns = array();
	public $relation_columns = array();
	public $relation_tables = array();
	private $db;
	private $model;
	private $uploaders = array();
	private $temp_uploaders;
	private $newclass = true;

	function __construct($model,$values=array()){
		$this->db = new dbConnect;
		$this->model = $model;
		$this->database_name = DATABASE_NAME;
		$string = preg_replace('/(?!^)[A-Z]/', "_$0" ,get_class($this->model));
		$this->table = strtolower($string);
		$this->columns = $this->get_columns();
		if($values){
			foreach ($values as $key => $value) {
				if(array_key_exists($key, $this->columns)){
					$this->columns[$key] = $value;
				}
			}
			$this->mount_actual_uploaders();
		}
	}

	function __get($column){
		if(array_key_exists($column, $this->columns)){
			return $this->columns[$column];
		}
	}

	function __set($column, $value){
		if(array_key_exists($column, $this->columns)){
			$this->columns[$column] = $value;
		}
	}

	private function get_columns(){
		$temp = array();
		$columns = $this->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$this->table' AND TABLE_SCHEMA ='$this->database_name';");
		foreach ($columns as $column) {
			$temp[$column['COLUMN_NAME']] = null;
		}
		$this->relation_tables = RelationManager::get_relations_for_model(get_class($this->model));
		if(count($this->relation_tables) > 0){
			foreach ($this->relation_tables as $table) {
				$temp["{$table}_relation_ids"] = array();
				array_push($this->relation_columns, "{$table}_relation_ids");
			}
		}
		return $temp;
	}

	private function make_update_query($values){
		$query = "UPDATE $this->table SET ";
		foreach ($values as $key => $value) {
			if($key != "id" && !in_array($key, $this->relation_columns)){
				if($value == "now()"){
					$query .= "`{$key}` = ".$value.", ";
				}elseif($value instanceof File){
					if(array_key_exists($key, $this->uploaders)){
						$uploader = $this->uploaders["{$key}"];
						$uploader_instance = new $uploader($value,get_class($this->model),$this->id);
						$value = $uploader_instance->get_file_name();
						$query .= "`{$key}` = '".$value."', ";
						unset($uploader_instance);
					}else{
						throw new Exception("Invalid uploader.");
					}
				}else{
					$query .= "`{$key}` = '".$value."', ";
				}
			}
		}
		$query = rtrim($query,", ");
		$query .= " WHERE `id` = {$this->id}";
		return $query;
	}

	private function make_insert_query($values){
		$query = "INSERT INTO `{$this->table}` ";
		$q1 = "(";
		$q2 = "(";
		foreach ($values as $key => $value) {
			if($key != "id" && !in_array($key, $this->relation_columns)){
				$q1 .= "`{$key}` , ";
				if($value == "now()"){
					$q2 .= $value.", ";
				}elseif($value instanceof File){
					if(array_key_exists($key, $this->uploaders)){
						$uploader = $this->uploaders["{$key}"];
						$status = $this->query("SHOW TABLE STATUS LIKE '{$this->table}'");
						$uploader_instance = new $uploader($value,get_class($this->model),$status[0]["Auto_increment"]);
						$value = $uploader_instance->get_file_name();
						unset($uploader_instance);
						$q2 .= "'".$value."', ";
					}else{
						throw new Exception("Invalid uploader.");
					}
				}else{
					$q2 .= "'".$value."', ";
				}
			}
		}
		$q1 = rtrim($q1,", ");
		$q2 = rtrim($q2,", ");
		$q1.=") VALUES ";
		$q2.=")";
		$query .= $q1 . $q2;

		return $query;
	}


	public function save(){
		$query = ($this->newclass ?  $this->make_insert_query($this->columns) : $this->make_update_query($this->columns));
		$results = $this->query($query);
		if($this->newclass){
			$this->columns['id'] = mysql_insert_id();
		}
		return $results;
	}

	public function add_relation($model, $obj){
		$id = null;
		switch (gettype($obj)){
			case "integer":
			$id = $obj;
			break;
			case "string":
			$id = (int)$obj;
			break;
			case "object":
			$id = $obj->id;
			break;
		}
		if($this->id){
			$model = RelationManager::tabelize($model);
			$thismodel = RelationManager::tabelize(get_class($this->model));
			if(in_array($model, $this->relation_tables)){
				$table_name = RelationManager::get_relation_table_for_models($thismodel,$model);
				$query = "INSERT INTO `{$table_name}` (`{$thismodel}_id`,`{$model}_id`) SELECT '{$this->id}','{$id}' FROM dual WHERE NOT EXISTS(SELECT * FROM `{$table_name}` WHERE `{$thismodel}_id` = '{$this->id}' AND `{$model}_id` = '{$id}')";
				$this->query($query);
			}
			array_push($this->columns["{$model}_relation_ids"],$id);
		}else{
			throw new Exception("Save the object before adding relations.");
		}
	}

	public function delete_relation($model, $obj){
		$id = null;
		switch (gettype($obj)){
			case "integer":
			$id = $obj;
			break;
			case "string":
			$id = (int)$obj;
			break;
			case "object":
			$id = $obj->id;
			break;
		}
		if($this->id){
			$model = RelationManager::tabelize($model);
			$thismodel = RelationManager::tabelize(get_class($this->model));
			if(in_array($model, $this->relation_tables)){
				$table_name = RelationManager::get_relation_table_for_models($thismodel,$model);
				$query = "DELETE FROM `{$table_name}` WHERE `{$thismodel}_id` = '{$this->id}' AND `{$model}_id` = '{$id}'";
				$this->query($query);
				$this->columns["{$model}_relation_ids"] = array_filter($this->columns["{$model}_relation_ids"],function($var) use($id){return($var != $id);});
			}
		}else{
			throw new Exception("Save the object before deleting relations.");
		}
	}



	public function update_values($values){
		$temp = array();
		foreach ($values as $key => $value) {
			if(array_key_exists($key, $this->columns)){
				$temp[$key] = $value;
			}
		}
		$query = $this->make_update_query($temp);
		$results = $this->query($query);
		return $results;
	}

	static public function find($id){
		$class = get_called_class();
		if(class_exists($class)){
			$c = new $class();
			$query = "SELECT * FROM $c->table WHERE id = $id";
			$results = $c->query($query);
			if($results != null){
				if($c->set_values($results[0])){
					return $c;
				}else{
					return null;
				}
			}else{
				return null;
			}
		}else{
			throw new Exception("Cannot find model class.");
		}
	} 

	static public function find_by($clauses){
		$class = get_called_class();
		if(class_exists($class)){
			$temp = array();
			$c = new $class();
			$db = new dbConnect();
			$query = "SELECT * FROM $c->table WHERE ";
			foreach ($clauses as $key => $value) {
				$query.= $key . " = '" . $value . "' and ";
			}
			$query = rtrim($query,"and ");
			$results = $c->query($query);
			unset($c);
			if($results != null){
				if($results){
					foreach ($results as $result) {
						$c = new $class();
						if($c->set_values($result)){
							array_push($temp, $c);
						}
						unset($c);
					}
					return $temp;
				}
			}else{
				return array();
			}
		}else{
			throw new Exception("Cannot find model class.");
		}
	} 

	static public function all($columns=array(),$sort=null){
		$class = (function_exists("get_called_class") ? get_called_class() : self::get_called_class());

		if(class_exists($class)){
			$temp = array();
			$c = new $class();
			$query = "SELECT * FROM $c->table";
			if(count($columns) > 0){
				$query.= " ORDER BY ";
				foreach ($columns as $column ) {
					$query.= $column . ", ";
				}
				$query = rtrim($query,", ");
				$query.= ($sort == null ? ";" : " " . $sort . ";");
			}
			$results = $c->query($query);
			unset($c);
			if($results){
				foreach ($results as $result) {
					$c = new $class();
					if($c->set_values($result)){
						array_push($temp, $c);
					}
					unset($c);
				}
				return $temp;
			}
		}else{
			throw new Exception("Cannot find model class.");
		}
	}

	public function delete(){
		return $this->query("DELETE FROM $this->table WHERE id = '$this->id'");
	}

	private function set_values($results){
		$this->newclass = false;
		if($results){
			foreach ($results as $key => $value) {
				$this->{$key} = $value;
			}
			$this->mount_actual_uploaders();
			if($this->set_relation_values()){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	private function set_relation_values(){
		foreach ($this->relation_tables as $table) {
			$temp = array();
			$thismodel = RelationManager::tabelize(get_class($this->model));
			$table_name = RelationManager::get_relation_table_for_models($thismodel,$table);
			$query = "SELECT `{$table}_id` FROM `{$table_name}` WHERE `{$thismodel}_id` = '{$this->id}'";
			$results = $this->query($query);
			if($results){
				foreach ($results as $result) {
					array_push($temp, (int)$result["{$table}_id"]);
				}
			}
			$this->columns["{$table}_relation_ids"] = $temp;
		}
		return true;
	}

	public static function escape($params){
		foreach ($params as $k => $v) {
			$params[$k] = (is_array($v) ? self::escape($v) : mysql_real_escape_string($v));
		}
		return $params;
	}

	public function query($query){
		return $this->db->query($query);
	}

	private function mount_actual_uploaders(){
		foreach ($this->temp_uploaders as $column => $uploader){
			$file = UPLOADER_PATH . $uploader . "_uploader.php";
			if(file_exists($file)){
				$uploader_file = $uploader . "_uploader";
				$class = classify($uploader_file);
				if(!class_exists($class)){
					require $file;
					if(!class_exists($class)){
						throw new Exception("Cannot find uploader class {$class}", 1);
					}else{
						$this->set_uploaders($column,$class);
					}
				}else{
					$this->set_uploaders($column,$class);
				}
			}else{
				throw new Exception("Cannot find uploader {$uploader}", 1);
			}
		}
	}

	public function mount_uploaders($uploaders){
		$this->temp_uploaders = $uploaders;
	}

	private function set_uploaders($column,$uploader){
		$this->uploaders["{$column}"] = $uploader;
		if($this->{$column} != null && !$this->{$column} instanceof File){
			$uploader_instance = new $uploader(null,get_class($this->model),$this->id);
			$this->{$column} = $uploader_instance->get_file($this->{$column});
		}
	}

	function __destruct(){
		$this->db->destruct();
	}
}
?>