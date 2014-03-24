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
	if(filter_var($js, FILTER_VALIDATE_URL)){
		return '<script type="text/javascript" src="'.$js.'"></script>';
	}else if(file_exists(rtrim(APP_PATH,"/").ASSETS."javascripts/".$js)){
		return '<script type="text/javascript" src="'.APP_DIR.ASSETS."javascripts/".$js.'"></script>';
	}else if(substr($js,0,2)=="//"){
		return '<script type="text/javascript" src="'.$js.'"></script>';
	}
}

function css_tag($css){
	if(filter_var($css, FILTER_VALIDATE_URL)){
		return '<link href="'.$css.'" rel="stylesheet" />';
	}else if(file_exists(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$css)){
		return '<link rel="stylesheet" href="'.APP_DIR.ASSETS."stylesheets/".$css.'" />';
	}else if(substr($css,0,2)=="//"){
		return '<link href="'.$css.'" rel="stylesheet" />';

	}
}

function scss_tag($css){
	if(file_exists(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$css)){
		$sass = new SassParser(array('style'=>'nested'));
     	$output = $sass->toCss(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$css);
     	$css_name = explode(".", $css);
     	$css_name = $css_name[0];
     	$file = $css_name.".css";
     	$handle = fopen(rtrim(APP_PATH,"/").ASSETS."stylesheets/".$file,"w") or die("Cannot create css file from scss");
     	fwrite($handle,$output);
     	fclose($handle);
     	return '<link rel="stylesheet" href="'.APP_DIR.ASSETS."stylesheets/".$file.'" />';
     	
	} 
}

function img_tag($img,$options = array()){
	$html = "";
	foreach ($options as $key => $value) {
		$html.= $key."='".$value."' ";
	}
	if(filter_var($img, FILTER_VALIDATE_URL)){
		return "<img src='".$img."'".$html." />";
	}else if(file_exists(rtrim(APP_PATH,"/").ASSETS."images/".$img)){
		return "<img src='".APP_DIR.ASSETS."images/".$img."'".$html." />";
	}
}


function mail_factory(){
	require_once 'lib/PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	// $mail->isSMTP();
	$mail->CharSet = 'utf-8';
	// $mail->Host = MAIL_HOST;
	// $mail->SMTPAuth = true;
	// $mail->Username = MAIL_USERNAME;
	// $mail->Password = MAIL_PASSWORD;
	// $mail->SMTPSecure = 'ssl';
	// $mail->Port = 465;
	// this is need for godaddy
	$mail->setFrom(MAIL_USERNAME, MAIL_NAME);

	$mail->isHTML(true);
	return $mail;
}



?>