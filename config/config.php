<?php
// user settings

define('DEBUG', false);
define('DB_NAME', 'mymvc');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', 'localhost');

// this one work if the server is not on godaddy
// define('MAIL_HOST', 'smtpout.secureserver.net');
// this one work if the server is on godaddy
define('MAIL_HOST', 'relay-hosting.secureserver.net');
define('MAIL_USERNAME', 'service@tollmequick.com');
define('MAIL_NAME', 'service');
define('MAIL_PASSWORD', 'Tollmequick#1');

//session options
define("SESSION",false);
// define('USER_MODEL','user');
// define("LOGIN_URL","/user/login");
// $SESSION_VARS = array("id","username","name","email","update_time","created_time");

?>