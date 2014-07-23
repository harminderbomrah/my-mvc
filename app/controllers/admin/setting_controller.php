<?php

class SettingController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $this->initial = array(
      "title" => "良錡石材",
      "description" => "全台最專業石材設計供應"
    );
    return render();
  }

  function update(){
    return renderJson(array("success"=>true ));
  }

  function checkpassword() {
    if($this->params['password']!='ray'){
      return renderJson(array("success"=>false));
    }else{
      return renderJson(array("success"=>true));
    }
  }

  function changepassword(){
    return renderJson(array("success"=>true ));
  }
}
?>