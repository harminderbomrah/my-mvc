<?php

class modalController extends ApplicationController{
  var $controller_layout = "modal";
  function index() {
    return render();
  }
  function fileManage() {
    $this->initial = array(
      "location" => "/public/file/",
      "file" => array(
        array("id" => 134512, "name" => "stone01", "type" => "jpg", "class" => "image"),
        array("id" => 683432, "name" => "stone02", "type" => "jpg", "class" => "image"),
        array("id" => 923741, "name" => "stone03", "type" => "jpg", "class" => "image"),
        array("id" => 965728, "name" => "stone04", "type" => "jpg", "class" => "image"),
        array("id" => 456891, "name" => "stone05", "type" => "jpg", "class" => "image"),
        array("id" => 763452, "name" => "stone06", "type" => "jpg", "class" => "image"),
        array("id" => 904246, "name" => "stone07", "type" => "jpg", "class" => "image"),
        array("id" => 782469, "name" => "stone08", "type" => "jpg", "class" => "image"),
        array("id" => 893279, "name" => "stone09", "type" => "jpg", "class" => "image"),
        array("id" => 004352, "name" => "stone10", "type" => "jpg", "class" => "image"),
        array("id" => 121783, "name" => "stone11", "type" => "jpg", "class" => "image"),
        array("id" => 727682, "name" => "stone12", "type" => "jpg", "class" => "image"),
        array("id" => 893272, "name" => "stone13", "type" => "jpg", "class" => "image"),
        array("id" => 663278, "name" => "stone14", "type" => "jpg", "class" => "image"),
        array("id" => 246782, "name" => "stone15", "type" => "jpg", "class" => "image"),
        array("id" => 832472, "name" => "stone16", "type" => "jpg", "class" => "image"),
        array("id" => 768315, "name" => "stone17", "type" => "jpg", "class" => "image"),
        array("id" => 935629, "name" => "stone18", "type" => "jpg", "class" => "image"),
        array("id" => 589035, "name" => "stone19", "type" => "jpg", "class" => "image"),
        array("id" => 802468, "name" => "stone20", "type" => "jpg", "class" => "image"),
        array("id" => 890356, "name" => "stone21", "type" => "jpg", "class" => "image"),
        array("id" => 793517, "name" => "stone22", "type" => "jpg", "class" => "image"),
        array("id" => 045619, "name" => "stone23", "type" => "jpg", "class" => "image"),
        array("id" => 467035, "name" => "stone24", "type" => "jpg", "class" => "image"),
        array("id" => 935627, "name" => "stone25", "type" => "jpg", "class" => "image"),
        array("id" => 468035, "name" => "stone26", "type" => "jpg", "class" => "image"),
        array("id" => 368285, "name" => "stone27", "type" => "jpg", "class" => "image"),
        array("id" => 239367, "name" => "stone28", "type" => "jpg", "class" => "image"),
        array("id" => 582256, "name" => "stone29", "type" => "jpg", "class" => "image"),
        array("id" => 799356, "name" => "stone30", "type" => "jpg", "class" => "image")
      )
    );
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