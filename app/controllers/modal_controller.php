<?php

class modalController extends ApplicationController{
  var $controller_layout = "modal";
  function index() {
    return render();
  }
  function fileManage() {
    $assets = Assets::all();
    $files = array();

    if(count($assets)>0){
      foreach ($assets as $asset) {
        array_push($files,array("id" => $asset->id, "name" => $asset->file->name, "type" => $asset->file->extension, "source" => array(
            "small" => '/'.$asset->file->path,
            "medium" => '/'.$asset->file->path,
            "large" => '/'.$asset->file->path,
            "original" => '/'.$asset->file->path
          )));
      }
      $this->initial = array(
        "file" => $files
      );
    }
    return render();
  }
  function delete_confirm() {
    return render();
  }
  function delete_category() {
    return render();
  }
  function delete_tag() {
    return render();
  }
}
?>