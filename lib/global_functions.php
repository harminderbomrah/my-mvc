<?php

if(!function_exists("get_called_class")){
	function get_called_class($bt = false,$l = 1) {
	    if (!$bt) $bt = debug_backtrace();
	    if (!isset($bt[$l])) throw new Exception("Cannot find called class -> stack level too deep.");
	    if (!isset($bt[$l]['type'])) {
	        throw new Exception ('type not set');
	    }
	    else switch ($bt[$l]['type']) {
	        case '::':
	            $lines = file($bt[$l]['file']);
	            $i = 0;
	            $callerLine = '';
	            do {
	                $i++;
	                $callerLine = $lines[$bt[$l]['line']-$i] . $callerLine;
	            } while (stripos($callerLine,$bt[$l]['function']) === false);
	            preg_match('/([a-zA-Z0-9\_]+)::'.$bt[$l]['function'].'/',
	                        $callerLine,
	                        $matches);
	            if (!isset($matches[1])) {
	                // must be an edge case.
	                throw new Exception ("Could not find caller class: originating method call is obscured.");
	            }
	            switch ($matches[1]) {
	                case 'self':
	                case 'parent':
	                    return get_called_class($bt,$l+1);
	                default:
	                    return $matches[1];
	            }
	            // won't get here.
	        case '->': switch ($bt[$l]['function']) {
	                case '__get':
	                    // edge case -> get class of calling object
	                    if (!is_object($bt[$l]['object'])) throw new Exception ("Edge case fail. __get called on non object.");
	                    return get_class($bt[$l]['object']);
	                default: return $bt[$l]['class'];
	            }

	        default: throw new Exception ("Unknown backtrace method type");
	    }
	}
}


function js_tag($js){
	$site_directory = (defined("SITE_DIRECTORY") ? SITE_DIRECTORY : "");
	if(filter_var($js, FILTER_VALIDATE_URL)){
		return "<script type='text/javascript' src='".$js."''></script>";
	}else if(file_exists(rtrim(APP_PATH,"/").ASSETS."javascripts/".$js)){
		return "<script type='text/javascript' src='".$site_directory.ASSETS."javascripts/".$js."''></script>";
	}else if(substr($js,0,2)=="//"){
		return "<script type='text/javascript' src='".$js."'></script>";
	}
}

function css_tag($css){
	$site_directory = (defined("SITE_DIRECTORY") ? SITE_DIRECTORY : "");
	$extension = explode(".",$css);
	$extension = end($extension);
	if(filter_var($css, FILTER_VALIDATE_URL)){
		return '<link href="'.$css.'" rel="stylesheet" />';
	}else if($extension == "scss" || $extension == "sass"){
		return '<link rel="stylesheet" href="'.parse_scss($css,$extension).'" />';
	}else if(file_exists(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$css)){
		return '<link rel="stylesheet" href="'.$site_directory.ASSETS."stylesheets/".$css.'" />';
	}else if(substr($css,0,2)=="//"){
		return '<link href="'.$css.'" rel="stylesheet" />';
	}
}

function content_css_tag($css){
	$site_directory = (defined("SITE_DIRECTORY") ? SITE_DIRECTORY : "");
	$extension = explode(".",$css);
	$extension = end($extension);
	if(filter_var($css, FILTER_VALIDATE_URL)){
		array_push(ViewAdapter::$content_stylesheets, $css);
	}else if($extension == "scss" || $extension == "sass"){
		array_push(ViewAdapter::$content_stylesheets, parse_scss($css,$extension));
	}else if(file_exists(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$css)){
		array_push(ViewAdapter::$content_stylesheets, $site_directory.ASSETS."stylesheets/".$css);
	}else if(substr($css,0,2)=="//"){
		array_push(ViewAdapter::$content_stylesheets,$css);
	}
	return "";
}

function parse_scss($css,$css_type="scss"){

	if(SITE_PRODUCTION_MODE){
		$css_temp = explode(".",$css);
		return ASSETS."stylesheets/".$css_temp[0].".css";
	}else{
		if(file_exists(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$css)){
			if($css_type == "sass"){
				$sass = new SassParser();
	     		$output = $sass->toCss(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$css);
	     	}else if($css_type == "scss"){
		     	$scss = new scssc();
		     	$scss->setImportPaths(rtrim(APP_PATH,"/").ASSETS."stylesheets/");
		     	$input = file_get_contents(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$css);
		     	$output = $scss->compile($input);
	     	}
	     	$css_name = explode(".", $css);
	     	$css_name = $css_name[0];
	     	$file = $css_name.".css";
	     	$handle = fopen(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$file,"w") or die("Cannot create css file from scss");
	     	fwrite($handle,$output);
	     	fclose($handle);
	     	return ASSETS."stylesheets/".$file;
		} 
	}
}


function img_tag($img,$options = array()){
	$site_directory = (defined("SITE_DIRECTORY") ? SITE_DIRECTORY : "");
	if($img instanceof File){
		$html = "";
		foreach ($options as $key => $value) {
			$html.= $key."='".$value."' ";
		}
		return "<img src='{$img->to_absolute_url()}'".$html." />";
	}else{
		$html = "";
		foreach ($options as $key => $value) {
			$html.= $key."='".$value."' ";
		}
		if(filter_var($img, FILTER_VALIDATE_URL)){
			return "<img src='".$img."'".$html." />";
		}else if(file_exists(rtrim(APP_PATH,"/").ASSETS."images/".$img)){
			return "<img src='".$site_directory.ASSETS."images/".$img."'".$html." />";
		}
	}
}

function include_helper($helper){
	if(is_array($helper)){
		for($i = 0 ; $i < count($helper); $i++){
			$path = APP_PATH . HELPERS . "/{$helper[$i]}.php";
			if(file_exists($path)){
				require $path;
			}else{
				throw new Exception("Helper {$helper[$i]} not found.");
			}
		}
	}else{
		$path = APP_PATH . HELPERS . "/{$helper}.php";
		if(file_exists($path)){
			require $path;
		}else{
			throw new Exception("Helper {$helper} not found.");
		}
	}
}

function render_page_specific_css(){
	$head = "";
	if(count(ViewAdapter::$content_stylesheets) > 0){
		foreach (ViewAdapter::$content_stylesheets as $css) {
			$head .= "<link href='".$css."' rel='stylesheet' />";
		}
	}
	return $head;
}

function classify($class){
	$class = ucwords($class);
	$class = preg_replace_callback('/(?!^)_+[a-z]/', function($matches){
		foreach ($matches as $match) {
			return ucwords(str_replace("_", "", $match));
		}
	},$class);
	return $class;
}

function tabelize($class){
	$class = preg_replace('/(?!^)[A-Z]/', "_$0" ,$class);
	return strtolower($class);
}




?>