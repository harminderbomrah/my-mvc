<?php

class Mailer extends PHPMailer{

	public function __construct(){
		
		parent::__construct(DEBUG);

		if(MAIL_HOST != "localhost"){
			$this->IsSMTP();
			$this->SMTPDebug  = 0;             // enables SMTP debug information (for testing)
			$this->SMTPAuth   = true;          // enable SMTP authentication
			$this->Host       = MAIL_HOST;     // sets the SMTP server
			$this->Port       = MAIL_PORT;     // set the SMTP port for the GMAIL server
			$this->Username   = MAIL_USERNAME; // SMTP account username
			$this->Password   = MAIL_PASSWORD;
			$this->CharSet    = "UTF-8";
			if(MAIL_SECURITY != null){
				$this->SMTPSecure = MAIL_SECURITY;   
			}
		}

		$this->SetFrom(MAIL_USERNAME, MAIL_NAME);
	}

	public function setMsgFromMailer($mailer){
		if(file_exists(APP_PATH.MAILER_PATH."/".$mailer.".php")){
			$variables = ViewAdapter::$VARIABLES;
			foreach ($variables as $key => $value) {
				${$key} = $value;
			}
			$m = MAILER_PATH . $mailer . '.php';
			ob_start();
			include $m;
			$output = ob_get_contents();
			ob_end_clean();
			foreach ($variables as $key => $value) {
				if (isset(${$key})){
					unset(${$key});
				}
			}
			$this->MsgHTML($output);
		}else{
			throw new Exception("Mailer not found.");
		}
	}

}


?>