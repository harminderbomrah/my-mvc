<?php

//engine settings
date_default_timezone_set("UTC");
define("APP_PATH",rtrim(dirname(__file__),"config"),true);
define("CONTROLLER_PATH", "app/controllers/",true);
define("HOME_CONTROLLER","home",true);
define("VIEWS_PATH","app/views/",true);
define("LAYOUTS_PATH","app/views/layouts/",true);
define("DEFAULT_LAYOUT","default",true);
define('ASSETS','/app/assets/',true);
define('HELPERS','app/helpers/',true);
define('UPLOAD_FOLDER','files/',true);


?>