<?php
/**
 * abstract class, should write the Action function
 */

abstract class ApplicationController{
	public $params;
	public $CURRENT_USER;
	abstract function index();

	function __construct(){
		global $CURRENT_USER;
		$this->CURRENT_USER = $CURRENT_USER;
	}

	function http404(){
		return renderError('404');
	}
	public function setParams($params){
		$this->params = $params;
	}

	function __get($key){
		if(array_key_exists($key, ViewAdapter::$VARIABLES)){
			return ViewAdapter::$VARIABLES["{$key}"];
		}
	}

	function __set($key,$value){
		ViewAdapter::$VARIABLES["{$key}"] = $value;
	}
}

class ViewAdapter{
	public static $VARIABLES = array();
	function __construct(){

	}
}



class http404Controller extends ApplicationController{
	function index(){
		return renderError('404');
	}
}
?>