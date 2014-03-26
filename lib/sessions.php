<?php
final class Session{

	var $model;
	var $session_vars;

	function __construct(){
		if(!defined("SESSION_USER_MODEL")){
			throw new Exception("User table model not specified in settings.");
		}else{
			$this->model = SESSION_USER_MODEL;
		}
		if(!class_exists($this->model)){
			throw new Exception("User model not found.");
		}
		if(!defined("SESSION_LOGIN_URL")){
			throw new Exception("Login url not found in settings.");
		}
		global $SESSION_VARS;
		if(!isset($SESSION_VARS) || count($SESSION_VARS) == 0){
			throw new Exception("Session variable not present or empty.");
		}else{
			$this->session_vars = $SESSION_VARS;
		}
	}

	function __get($var){
		session_start();
		return $_SESSION[$var];
	}

	public function create($id){
		$id = (int)$id;
		session_start();
		$user = User::find($id);
		if($user != null){
			$this->set_vars($user);
			$_SESSION['loggedin'] = true;
			if($_SESSION['lasturl']){
				$redirect_url = $_SESSION['lasturl'];
				unset($_SESSION['lasturl']);
				redirect($redirect_url);
			}
			return true;
		}else{
			$_SESSION['loggedin'] = false;
			return false;
		}
	}

	private function set_vars($user){
		session_start();
		foreach ($this->session_vars as $key) {
			$_SESSION[$key] = $user->{$key};
		}
	}

	public function destroy(){
		session_unset();
		$_SESSION['loggedin'] = false;
	}

	public function needs_authentication(){
		$_SESSION['lasturl'] = Routes::current_url();
		if(!$this->loggedin){
			redirect(SESSION_LOGIN_URL);
		}
	}
	
}

$CURRENT_USER = new Session();
?>