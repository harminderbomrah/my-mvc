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
	public $controller_layout = "default";
	function index(){
		return render();
	}

	function login(){
		return render();
	}

	function logout(){
		$this->current_user->destroy();
		return redirect("/");
	}

	function resets(){
		return render();
	}

	function resets_new(){
		return render();
	}

	function success(){
		return render();
	}

	function check(){
		// echo password_hash($this->params['post']['password'], PASSWORD_DEFAULT);
		if($user = Users::find_by(array("username"=>$this->params["post"]["username"]))){
			if(password_verify( $this->params['post']['password'], $user[0]->password) ){
				$this->current_user->create($user[0]);
			}else{
				return redirect("/user/login");
			}
		}
		if($this->current_user->lasturl==null){
			return redirect("/admin");
		}
	}
}



?>
