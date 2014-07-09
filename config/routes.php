<?php 

/*
	* Controller#action => array(<all the routes here>), can put more than one route; eg 'home#index' => array("home","home1") both /home and /home1 will goto same controller and action.
	* routes can also have inbuilt params like "user/{name}" this will create a param called name which can be accessed in controller using $this->params['name'];
*/

	// Routes start here
	$ROUTE_RULES = array(
		'home#index' => array('home'),
		'home#upload' => array("file/upload"),
		'user#login' => array('user/login'),
		'user#check' => array('login/check'),
		'user#logout' => array('user/logout')
	);

?>