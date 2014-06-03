<?php
final class Routes {

	private $site_path;
	private $page;
	private $controller;
	private $controller_folder_path;
	private $controller_file_path;
	private $route_rules;
	private $default_controller;
	private $controller_name;
	private $action;
	private $url;
	private $params;

	function __construct($site_path=null){

		global $ROUTE_RULES;
		$this->route_rules = $ROUTE_RULES;
		$this->default_controller = HOME_CONTROLLER;
		$this->site_path = $this->remove_slash($site_path);
		$this->url = $this->remove_slash($_SERVER['REQUEST_URI']);
		$this->controller_folder_path = CONTROLLER_PATH;
		$this->params = array();
		
		if(isset($_POST)){
			$this->params['post'] = $_POST;
			foreach ($_POST as $key => $value) {
				$this->params["{$key}"] = $value;
			}
		}

		if(isset($_GET)){
			$this->params['get'] = $_GET;
			foreach ($_GET as $key => $value) {
				$this->params["{$key}"] = $value;
			}
		}

		if(count($_FILES) > 0){
			FileManager::upload($_FILES);
		}

   		$routes = $this->controller_action_name();
   		$this->controller_name = $routes['controller'];
   		$this->action = $routes['action'];

   		Request::$Controller = $this->controller_name;
   		Request::$Action = $this->action;

   		$this->controller_file_path = $this->controller_folder_path . $this->controller_name . "_controller.php";
   		$this->controller = $this->require_controller();
   		$this->controller->set_params($this->params);
   		if(!method_exists($this->controller, $this->action)){
   			if(DEBUG)
	   			throw new Exception("{$this->action} action not present in {$this->controller_name} controller.");
	   		else
   				$this->action = 'http404';
   		}
   		ViewAdapter::$controller_layout = $this->controller->controller_layout;
   		if($this->controller->before_filter){
	   		$this->execute_filters($this->controller->before_filter);
	   	}
   		if (!$this->controller->{$this->action}() instanceof httpResponse){
   			throw new Exception("Action must return the class which is instanceof httpResponse!");
   		}
   		if($this->controller->after_filter){
	   		$this->execute_filters($this->controller->after_filter);
	   	}
	   	if(count($_FILES) > 0){
	   		FileManager::delete_uploaded_files();
	   	}
	   
	}

	private function execute_filters($methods){
		if(is_array($methods)){
   			foreach($methods as $method){
   				if(method_exists($this->controller, $method)){
   					$this->controller->{$method}();
   				}
   			}
   		}else{
   			throw new Exception("Before & After filter methods should be specified in an array.");
   		}
	}

	private function remove_slash($string){
		$url = explode("?", $string);
		$string = trim($url[0],'/');
		$string = ($string ? $string : $this->default_controller);
		return $string;
	}

	function __toString(){
		return $this->site_path;
	}

	private function segment($segment){
		$url = str_replace($this->site_path,'', $_SERVER['REQUEST_URI']);
		$url = explode("/",$url);
		if(isset($url[$segment])){
			$x = strpos($url[$segment],"?");
			if($x === false){
				return $url[$segment];
			}else{
				$y = explode("?", $url[$segment]);
				return $y[0];
			}
		}else{
			return false;
		}
	}

	private function controller_action_name(){
		$combo = null;
		$url = $this->url;
		$segments = explode("/", $url);
		foreach ($this->route_rules as $controller_name => $match_rules) {
			$temp = explode("#", $controller_name);
			foreach ($match_rules as $rule) {
				preg_match_all('/{(.*?)}/', $rule, $matches,PREG_SET_ORDER);
				if(count($matches) != 0){
					$rule_segment = explode("/", $rule);
					for($i=0;$i<count($matches);$i++){
						for($x=0;$x<count($rule_segment);$x++){
							if($matches[$i][0] == $rule_segment[$x]){
								$matches[$i][2] = $x;
								$rule = str_replace($matches[$i][0], $segments[$x], $rule);
								$this->params[$matches[$i][1]] = $segments[$x];
							}
						}
					}
				}
				if($rule == $url){
					if(!isset($temp[1])){
						$temp[1] = "index";
					}
					$combo = array("controller"=>$temp[0],"action"=>$temp[1]);
					break;
				}
			}
			if($combo != null){
				break;
			}
		}
		return $combo;
	}

	private function require_controller(){
		if(file_exists($this->controller_file_path)){
			require $this->controller_file_path;
			$controller_class_name = ucwords($this->controller_name) . 'Controller';
		}
		else{
			$controller_class_name = 'http404Controller';
		}

		if(class_exists($controller_class_name)){
			$controller = new $controller_class_name();
			if(!$controller instanceof ApplicationController){
				throw new Exception("Controller should be the instanceof ApplicationController!");
			}
			return $controller;
		}
		else{
			if(DEBUG){
				throw new Exception("Can't find the controller class {$controller_class_name}");
			}else{
				return new http404Controller();
			}
		}
	}
	public static function current_url() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}


}


final class Request{
	public static $Controller;
	public static $Action;
}

?>