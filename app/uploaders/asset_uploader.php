<?php
class AssetUploader extends Uploader{
	function __construct($file,$model,$id){
		$this->create_version("thumb",array("width"=>150,"height"=>100,"scale"=>"crop"));
		parent::__construct($file,$model,$id);
	}
}
?>