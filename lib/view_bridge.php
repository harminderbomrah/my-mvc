<?php

class httpResponse{}

/**
 * the class include view and to check instanceof
 */
final class renderClass extends httpResponse{
	function __construct($view, $layout='default',$title){
		$layout = ($layout === true ? DEFAULT_LAYOUT : $layout);
		header("Content-Type: text/html; charset=utf-8");
		$templ_path = VIEWS_PATH . $view . '.php';
		$variables = ViewAdapter::$VARIABLES;
		foreach ($variables as $key => $value) {
			${$key} = $value;
		}
		if(file_exists($templ_path)){
			if($layout){
				if(file_exists(LAYOUTS_PATH . $layout . '/index.php')){
					ob_start();
					include $templ_path;
					$yield = ob_get_contents();
					ob_end_clean();
					$_site_title = $title;
					include LAYOUTS_PATH . $layout . '/index.php';
				}else{
					throw new Exception("Layout doesn't exists.");
				}
			}else{
				include $templ_path;
			}
		}
		else{
			throw new Exception("Template does not exist!");
		}

		foreach ($variables as $key => $value) {
			if (isset(${$key})){
				unset(${$key});
			}
		}
	}
}

final class renderError extends httpResponse{
	function __construct($error){
		switch ($error){
			case '404':
				header("HTTP/1.0 404 Not Found");
				break;
		}
		$tmpl_path = 'error_pages/' . $error . '.php';
		include $tmpl_path;
	}
}

final class redirectClass extends httpResponse{
	function __construct($url){
		header("Location: {$url}");
	}
}

final class jsonResponseClass extends httpResponse{
	function __construct($json){
		header("Content-Type: application/json; charset=utf-8");
		if(is_array($json)){
			$json = json_encode($json);
		}else{
			throw new Exception("Invalid JSON type");
		}
		echo $json;
	}
}

/**
 * short cut function for class renderClass
 * @param  [string] $template [description]
 * @param  [array or object] $view     [description]
 * @param  [string] the folder of header and footer
 * @return [object]           [a instance of renderClass]
 */
function render($options=array("view"=>null,"layout"=>true)){
	$options["view"] = (!$options["view"] ? Request::$Controller."/".Request::$Action : $options["view"]);
	$options["title"] = (!$options["title"] ? ucwords(Request::$Controller) . " - " . SITE_TITLE : $options["title"]);
	$options["layout"] = ($options["layout"] === false ? false : (is_string($options['layout']) ? $options['layout'] : true));
	return new renderClass($options["view"],$options["layout"],$options["title"]);
}

function redirect($url){
	return new redirectClass($url);
}

function renderJson($json){
	return new jsonResponseClass($json);
}

function renderError($error){
	return new renderError($error);
}

function render_partial($partial){
	if(file_exists(APP_PATH.VIEWS_PATH."/".$partial.".php")){
		$variables = ViewAdapter::$VARIABLES;
		foreach ($variables as $key => $value) {
			${$key} = $value;
		}
		$templ_path = VIEWS_PATH . $partial . '.php';
		ob_start();
		include $templ_path;
		$output = ob_get_contents();
		ob_end_clean();
		foreach ($variables as $key => $value) {
			if (isset(${$key})){
				unset(${$key});
			}
		}
		return $output;
	}
}

?>