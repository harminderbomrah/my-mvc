<?php

//engine settings
date_default_timezone_set("UTC");
define("APP_PATH",rtrim(dirname(__file__),"config"));
define("CONTROLLER_PATH", "app/controllers/");
define("HOME_CONTROLLER","home");
define("VIEWS_PATH","app/views/");
define("LAYOUTS_PATH","app/views/layouts/");
define("DEFAULT_LAYOUT","default");
define('ASSETS','/app/assets/');
define('UPLOAD_FOLDER','files/');
$temp = explode("/", APP_PATH);
define('APP_DIR',"/".$temp[count($temp)-2]);
unset($temp);

?>