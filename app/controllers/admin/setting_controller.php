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