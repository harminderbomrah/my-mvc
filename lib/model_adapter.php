<?php

class ModelAdapter{

	public $table;
	public $columns = array();
	public $CURRENT_USER;
	private $db;
	private $model;
	private $newclass = true;

	function __construct($model,$values=array()){
		global $CURRENT_USER;
		$this->CURRENT_USER = $CURRENT_USER;
		$this->db = new dbConnect;
		$this->model = $model;
		$this->table = strtolower(get_class($this->model));
		$this->columns = $this->get_columns();
		if($values){
			foreach ($values as $key => $value) {
				if(array_key_exists($key, $this->columns)){
					$this->columns[$key] = $value;
				}
			}
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
		$columns = $this->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$this->table';");
		foreach ($columns as $column) {
			$temp[$column['COLUMN_NAME']] = null;
		}
		return $temp;
	}

	private function make_update_query($values){
		$query = "UPDATE $this->table SET ";
		foreach ($values as $key => $value) {
			if($value == "now()")
				$query .= "`{$key}` = ".$value.", ";
			else
				$query .= "`{$key}` = '".$value."', ";
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
			if($key != "id"){
				$q1 .= "`{$key}` , ";
				if($value == "now()")
					$q2 .= $value.", ";
				else
					$q2 .= "'".$value."', ";

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
		if(!$this->newclass){
			$query = $this->make_update_query($this->columns);
		}else{
			$query = $this->make_insert_query($this->columns);
		}

		$results = $this->query($query);

		if($this->newclass){
			$this->columns['id'] = mysql_insert_id();
		}

		return $results;

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
			if($c->set_values($query))
				return $c;
			else
				return null;
		}else{
			throw new Exception("Cannot find model class.");
		}
	} 

	static public function find_by($clauses){
		$class = get_called_class();
		// $clauses = self::escape($clauses);
		if(class_exists($class)){
			$c = new $class();
			$query = "SELECT * FROM $c->table WHERE ";
			foreach ($clauses as $key => $value) {
				$query.= $key . " = '" . $value . "' and ";
			}
			$query = rtrim($query,"and ");
			if($c->set_values($query))
				return $c;
			else
				return null;
		}else{
			throw new Exception("Cannot find model class.");
		}
	} 

	static public function all(){
		if(function_exists("get_called_class"))
			$class = get_called_class();
		else
			$class = self::get_called_class_();

		if(class_exists($class)){
			$c = new $class();
			$query = "SELECT * FROM $c->table;";
			return $c->query($query);
		}else{
			throw new Exception("Cannot find model class.");
		}
	}

	public function delete(){
		return $this->query("DELETE FROM $this->table WHERE id = '$this->id'");
	}

	public function set_values($query){
		$this->newclass = false;
		$results = $this->query($query);
		if($results){
			foreach ($results[0] as $result => $value) {
				$this->{$result} = $value;
			}
			return true;
		}else{
			return null;
		}
	}

	public static function escape($params){
		foreach ($params as $k => $v) {
			if(is_array($v)){
				$params[$k] = self::escape($v);
			}
			else{
				$params[$k] = mysql_real_escape_string($v);
			}
		}
		return $params;
	}

	public function query($query){
		return $this->db->query($query);
	}

	
}
?>