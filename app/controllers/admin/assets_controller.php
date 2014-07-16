<?php
  class AssetsController extends ApplicationController{
    function index(){

    }
    function new_asset(){
      $files = FileManager::get_uploaded_files();
      $file = end($files);
      $asset = new Assets(array("file"=>$file));
      $asset->save();
      return renderJson(
        array("id" => $asset->id, "name" => $asset->file->name, "type" => $asset->file->extension, "source" => array(
          "small" => '/'.$asset->file->path,
          "medium" => '/'.$asset->file->path,
          "large" => '/'.$asset->file->path,
          "original" => '/'.$asset->file->path
        ))
      );
    }
    function delete_asset(){
      $asset = Assets::find($this->params['post']['id']);
      $asset->delete();
      return renderJson(array("success"=>true));
    }
  }
?>