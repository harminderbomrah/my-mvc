<?php

defineSettings(json_decode(file_get_contents("config/config.json"),true));

function defineSettings($data){
	foreach ($data as $key => $value) {
		
		if(is_array($value)){
			foreach ($value as $x => $y) {
				if("{$key}_{$x}" == "session_vars"){
					${strtoupper("{$key}_{$x}")} = $y;
				}else{
					define(strtoupper("{$key}_{$x}"),$y,true);
				}
			}
		}else{
			define(strtoupper($key),$value,true);
		}
	}
}

?>