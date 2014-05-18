<?php
/*
	* create a table Users with fields id, username, password, name and created_time.
	* enable sessions in config.json
	* current user can be accessed as follows $this->current_user, methods for current_user
		$this->current_user-><session_variables>
		$this->current_user->create(<user class instance>);
		$this->current_user->loggedin
		$this->current_user->destroy();
*/

class AdminController extends ApplicationController{
	public $controller_layout = "admin";
	function index(){
		return render();
	}
	function home(){
		return render();
	}
	function icon(){
		return render();
	}
}



?>