<?php
class AssetUploader extends Uploader{
	function __construct($file,$model,$id){
    $this->create_version("thumb",array("width"=>60,"height"=>60,"scale"=>"crop"));
    $this->create_version("large",array("width"=>600,"height"=>600,"scale"=>"auto"));
    $this->create_version("medium",array("width"=>300,"height"=>300,"scale"=>"auto"));
    $this->create_version("small",array("width"=>150,"height"=>150,"scale"=>"auto"));
		parent::__construct($file,$model,$id);
	}
}
?>