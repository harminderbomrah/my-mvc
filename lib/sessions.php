<?php
final class CurrentUser{

	private $model;
	private $session_vars;

	function __construct(){
		if(!defined("SESSION_USER_MODEL")){
			throw new Exception("User table model not specified in settings.");
		}else{
			$this->model = ucwords(SESSION_USER_MODEL);
		}
		if(!class_exists($this->model)){
			throw new Exception("User model not found.");
		}
		if(!defined("SESSION_LOGIN_URL")){
			throw new Exception("Login url not found in settings.");
		}
		$temp_session_vars = explode(",",SESSION_VARS);
		if(!isset($temp_session_vars) || count($temp_session_vars) == 0){
			throw new Exception("Session variables not present or empty.");
		}else{
			$this->session_vars = $temp_session_vars;
		}
	}

	function __get($var){
		session_start();
		return $_SESSION[$var];
	}

	public function create($user){
		if($user != null){
			if($user instanceof $this->model){
				$this->set_vars($user);
				$_SESSION['loggedin'] = true;
				if($_SESSION['lasturl']){
					$redirect_url = $_SESSION['lasturl'];
					unset($_SESSION['lasturl']);
					redirect($redirect_url);
				}
				return true;
			}else{
				throw new Exception("Passed user is not instance of User model.");
			}
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
?>