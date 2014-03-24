<?php
class file{

	var $dir;
	var $sitepath;

	function __construct(){
		$this->dir = "/home/promisea/public_html/test/files/";
		$this->sitepath = "http://www.promiseasmile.com/test/files/";
	}

	function upload($file){
		$date = getdate();
		$ext = explode("/",$file['type']);
		$filename = md5($date[0]).".".$ext[1];
		$filedir = $this->dir.$filename;
		if (move_uploaded_file($file['tmp_name'], $filedir)){
			return $this->sitepath.$filename;
		}else {
			return "Error uploading file.";
		}
		
	}

	function is_valid_filename($filename){
		$filename_re = '';
		return true;
	}

}

?>