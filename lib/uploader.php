<?php

class Uploader{
	private $file;
	private $model;
	private $record_id;
	function __construct($file,$model,$id){
		$this->file = $file;
		$this->model = strtolower($model);
		$this->record_id = $id;
		if($this->file != null){
			$this->file->save($this->path_to_save()."original/",true);
		}
	}

	public function path_to_save(){
		return "{$this->model}/{$this->record_id}/";
	}

	public function get_file_name(){
		return $this->file->name;
	}
	public function get_file($file){
		return File::get($this->path_to_save()."original/{$file}");
	}
}

?>