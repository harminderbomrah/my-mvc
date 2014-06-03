<?php

//includes classses and models


//classes
include "lib/global_functions.php";
include "lib/global_variables.php";
// // include application settings
include "config/application.php";
// // include user configuration settings
$settings = file_get_contents("config/config.json");
include 'lib/read_config.php';
unset($settings);

include 'lib/simple_html_dom.php';
// include routes
include "config/routes.php";

include "lib/model_adapter.php";
include "lib/view_bridge.php";
include "lib/controller_class.php";
include "lib/file_manager.php";
include "lib/routes.php";

// include sass parser
include "lib/phpsass/SassParser.php";
include "lib/scssphp/scss.inc.php";

if(DATABASE_ENABLE){
	include "lib/dbconnections_class.php";
	
	function includeModels(){
		$db = new dbConnect;
		$tables = $db->table_list();
		if ($tables){
			foreach ($tables as $table) {
				foreach ($table as $key => $value) {
					$temp = explode("_", $value);
					if($temp[count($temp) - 1] != "mvcrelation"){
						if(file_exists("app/models/{$value}_model.php")){
							require "app/models/{$value}_model.php";
							if(count($temp) == 0){
								if(!class_exists(ucwords($value))){
									throw new Exception("Model for table '{$value}' doesn't exists.");
								}
							}else{
								$model_name = "";
								foreach ($temp as $value) {
									$model_name.= ucwords($value);
								}
								if(!class_exists($model_name)){
									throw new Exception("Model for table '{$value}' doesn't exists.");
								}
							}
						}else{
							throw new Exception("Model for table '{$value}' doesn't exists.");
						}
					}
				}
			}
		}
	}
	includeModels();
	include "lib/table_relation_manager.php";
	include "app/models/model_relationships.php";
	if(SESSION_ENABLE){
		include "lib/sessions.php";
	}
}



?>
