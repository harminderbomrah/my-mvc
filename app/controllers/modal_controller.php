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
        array_push($files,array("id" => $asset->id, "name" => $asset->file["original"]->name, "type" => $asset->file["original"]->extension, "source" => array(
            "thumb" => '/'.$asset->file["thumb"]->path,
            "small" => '/'.$asset->file["small"]->path,
            "medium" => '/'.$asset->file["medium"]->path,
            "large" => '/'.$asset->file["large"]->path,
            "original" => '/'.$asset->file["original"]->path
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