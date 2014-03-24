<?php
class dbConnect{
	private $dbname;
	private $dbuser;
	private $dbpassword;
	private $dbhost;
	private $dbConnection;
	
	function __construct(){
		$this->dbname = DB_NAME;
		$this->dbuser = DB_USER;
		$this->dbpassword = DB_PASSWORD;
		$this->dbhost = DB_HOST;
		$this->dbConnection = mysql_connect($this->dbhost,$this->dbuser,$this->dbpassword) or die(mysql_error());
	}

	function __destruct(){
		if(is_resource($this->dbConnection) && get_resource_type($this->dbConnection) === 'mysql link')
			mysql_close($this->dbConnection);
	}
	
	function query($sql){
		$data = array();
		if(mysql_select_db($this->dbname,$this->dbConnection)){
			mysql_query("SET CHARSET UTF8");
			$result = mysql_query($sql, $this->dbConnection) or die(mysql_error());
			if($result==1)
				$count=0;
			else
				$count=mysql_num_rows($result);

			for($i=0;$i<$count;$i++){
				$row = mysql_fetch_array($result,MYSQL_ASSOC);
				foreach ($row as $key => $value) {
					$data[$i][$key]=$row[$key];
				}
			}

			if(count($data) == 0)
				return null;
			else
				return $data;
		}
	}
		
	function getJson($sql){
		$data=array();
		mysql_select_db($this->dbname,$this->dbConnection);
		mysql_query("SET CHARSET UTF8");
		$result = mysql_query($sql, $this->dbConnection) or die(mysql_error());
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)){
			$data[] = $row;
		}
		return json_encode($data);
	}

	function table_list(){
		return $this->query("show tables");
	}

}
?>