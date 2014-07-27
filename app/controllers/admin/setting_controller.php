<?php

class SettingController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $site = Site::all()[0];
    $this->initial = array(
      "title" => $site->title,
      "description" => $site->description
    );
    return render();
  }

  function update(){
    if($site = Site::all()[0]){
      $site->title = $this->params['title'];
      $site->description = $this->params['description'];
      $site->save();
      return renderJson(array("success"=>true ));
    }else{
      return renderJson(array("success"=>false ));
    }
  }

  function checkpassword() {
    if( $user = Users::find_by(array("username"=>$this->current_user->username)) ){
      if(!password_verify( $this->params['password'], $user[0]->password) ){
          return renderJson(array("success"=>false));
        }else{
          return renderJson(array("success"=>true));
        }
    }else{
      return renderJson(array("success"=>null));
    }
  }

  function changepassword(){
    if( $user = Users::find($this->current_user->id) ){
      $user->password = password_hash($this->params['password'], PASSWORD_DEFAULT);
      $user->save();
      return renderJson(array("success"=>true ));
    }else{
      return renderJson(array("success"=>false ));
    }
  }
}
?>