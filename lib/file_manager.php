<?php
class FileManager{

	private static $pathname;
	private static $uploaded_files = array();

	public static function upload($files){
		$now = new DateTime();
		self::$pathname = CACHE_FOLDER . $now->getTimestamp();
		if(!file_exists(self::$pathname)){
			mkdir(self::$pathname);
		}
		foreach ($files as $file) {
			$destination = self::$pathname."/".$file['name'];
			if(move_uploaded_file($file['tmp_name'], $destination)){
				array_push(self::$uploaded_files, new File($destination));
			}
		}
	}

	public static function get_uploaded_files(){
		return self::$uploaded_files;
	}

	public static function delete_uploaded_files(){
		if(file_exists(self::$pathname)){
			$files = glob(self::$pathname);
			foreach($files as $file){
  				if(is_file($file)){
    				unlink($file);
				}
			}
			rmdir(self::$pathname);
		}
	}

	public static function get($filepath){
		return File::get($filepath);
	}
}

class File{
	public $name; // gives name of the file 
	public $path; // gives the full path including name
	public $extension; // gives the extension of the file
	public $absolute_path; // gives the full path without name
	private $cachefolder;
	private $temp_path;
	private $new_file = true;
	private $handle;
	public function __construct($filename){
		$now = new DateTime(); 
		$this->cachefolder = $now->getTimestamp();
		$this->temp_path = CACHE_FOLDER . $this->cachefolder;
		if(!file_exists($filename)){
			$this->name = $filename;
			$this->path = $this->temp_path . "/" . $this->name;
			$this->absolute_path = $this->temp_path ."/";
			$this->create_temp_folder();
			if(file_exists($this->path)){
				unlink($this->path);
			}
			$this->handle = fopen($this->path, "w") or die("Cannot create file {$this->name}.");
		}else{
			$this->new_file = false;
			$temp = explode("/", $filename);
			$this->name = end($temp);
			$this->path = $filename;
			$this->absolute_path = str_replace("{$this->name}", "", $filename);
		}
		$this->extension = $this->get_extension();
	}
	public function __destruct(){
		if($this->handle){
			fclose($this->handle);
		}
		if($this->new_file){
			$this->destroy();
		}
		$files = glob($this->temp_path);
		if(count($files) > 0){
			rmdir($this->temp_path);
		}

	}
	private function create_temp_folder(){
		if(!file_exists($this->temp_path)){
			mkdir($this->temp_path);
		}
	}

	public function destroy(){
		unlink($this->path);
	}

	public function save($path = null,$overwrite = false){
		if(is_bool($path)){
			$overwrite = $path;
			$path = null;
		}
		if($path != null){
			$path = rtrim($path, "/");
			$path = ltrim($path, "/");
			$folders = explode("/", $path);
			$path = rtrim(UPLOAD_FOLDER,"/");
			foreach ($folders as $folder) {
				if(!file_exists($path."/{$folder}")){
					mkdir($path."/{$folder}");
				}
				$path = $path . "/{$folder}";
			}
			if($overwrite){
				rename($this->path,$path."/{$this->name}");
			}else{
				if(file_exists($path."/{$this->name}")){
					throw new Exception("File already exists."); 
				}else{
					rename($this->path,$path."/{$this->name}");
				}
			}
			$this->path = $path ."/{$this->name}";
			$this->absolute_path = $path ."/";
			$this->new_file = false;
		}else{
			if(!$this->new_file){
				if($overwrite){
					rename($this->path,$this->absolute_path.$this->name);
				}else{
					if(file_exists($this->absolute_path.$this->name)){
						throw new Exception("File already exists."); 
					}else{
						rename($this->path,$this->absolute_path.$this->name);
					}
				}
			}
			$this->path = $this->absolute_path.$this->name;
		}
		$this->extension = $this->get_extension();
	}

	public function rename($name,$overwrite = false){
		if($overwrite){
			rename($this->path,$this->absolute_path."{$name}");
		}else{
			if(file_exists($this->absolute_path."{$name}")){
				throw new Exception("File already exists with name {$name}");
			}else{
				rename($this->path,$this->absolute_path."{$name}");
			}
			$this->name = $name;
			$this->extension = $this->get_extension();
		}
	}

	public static function get($filepath){
		$filepath = rtrim($filepath, "/");
		$filepath = ltrim($filepath, "/");
		$filepath = UPLOAD_FOLDER.$filepath;
		if(file_exists($filepath)){
			return new File($filepath);
		}else{
			throw new Exception("File not found.");
		}
	}


	public function write($data){
		fwrite($this->handle, $data);
	}

	public function read(){
		file_get_contents($this->path);
	}

	public function to_absolute_url(){
		return "/" . $this->path;
	}

	private function get_extension(){
		$temp = explode(".", $this->name);
		return end($temp);
	}

}
?>