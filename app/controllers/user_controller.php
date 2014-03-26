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

class UserController extends ApplicationController{
	function index(){
		return render();
	}

	function login(){
		return render();
	}

	function logout(){
		$this->current_user->destroy();
		return redirect("home");
	}

	function check(){
		if($user = Users::find_by(array("username"=>$this->params["post"]["username"],"password"=>$this->params['post']['password']))){
			if($this->current_user->create($user)){
				return redirect("home");
			}else{
				return redirect("user/login");
			}
		}else{
			return redirect("user/login");
		}
	}
}



?>