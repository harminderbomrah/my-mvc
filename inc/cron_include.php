<?php

//includes classses and models


//classes
include "../lib/global_functions.php";
// include application settings
include "../config/application.php";
// include user configuration settings
include '../lib/read_config.php';
// include routes

include "../lib/dbconnections_class.php";
include "../lib/model_adapter.php";
include "../lib/view_bridge.php";


if(DATABASE_ENABLE){
	include "lib/dbconnections_class.php";
	includeModels();

	function includeModels(){
		$db = new dbConnect;
		$tables = $db->table_list();
		if ($tables){
			foreach ($tables as $table) {
				foreach ($table as $key => $value) {
					if(file_exists("../app/models/{$value}_model.php")){
						require "../app/models/{$value}_model.php";
						if(!class_exists(ucwords($value))){
							throw new Exception("Model for table '{$value}' doesn't exists.");
						}
					}else{
						throw new Exception("Model for table '{$value}' doesn't exists.");
					}
				}
			}
		}
	}
}

?>
