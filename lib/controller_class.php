<?php
/**
 * abstract class, should write the Action function
 */

abstract class ApplicationController{
	protected $params;
	protected $current_user;
	abstract function index();

	function __construct(){
		if(SESSION_ENABLE && DATABASE_ENABLE){
			$this->current_user = new CurrentUser();
		}else{
			$this->current_user = null;
		}
	}

	function http404(){
		return renderError('404');
	}
	public function set_params($params){
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

final class ViewAdapter{
	public static $VARIABLES = array();
	public static $content_stylesheets = array();
	public static $controller_layout = null;
	function __construct(){

	}
}

final class http404Controller extends ApplicationController{
	function index(){
		return renderError('404');
	}
}
?>