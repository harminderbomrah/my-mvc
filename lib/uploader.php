<?php

class Uploader{
	private $file;
	private $model;
	private $record_id;
	private $versions = array();
	function __construct($file,$model,$id){
		$this->file = $file;
		$this->model = strtolower($model);
		$this->versions["original"] = array();
		$this->record_id = $id;
		if($this->file != null){
			$this->create_versions();			
		}
	}

	public function create_version($name, $options){
		$this->versions["{$name}"] = $options;
	}

	private function create_versions(){
		if(count($this->versions) > 0){
			if($this->file->is_image()){
				foreach ($this->versions as $version => $options) {
					if(count($options) > 0){
						$resize = new Resize($this->file);
						$resize->resizeImage($options["width"],$options["height"],$options["scale"]);
						$f = $resize->saveImage(100);
						$f->save($this->path_to_save()."{$version}/",true);
						unset($f);
						unset($resize);
					}
				}
			}
		}
		$this->file->save($this->path_to_save()."original/",true);
	}

	public function path_to_save(){
		return "{$this->model}/{$this->record_id}/";
	}

	public function get_file_name(){
		return $this->file->name;
	}
	public function get_file($file){
		$temp = array();
		if(count($this->versions) > 0){
			foreach ($this->versions as $version => $options) {
				$filepath = $this->path_to_save()."{$version}/{$file}";
				if(file_exists(UPLOAD_FOLDER . $filepath)){
					$temp["{$version}"] = File::get($filepath);
				}
			}
		}
		return $temp;
	}
}

?>