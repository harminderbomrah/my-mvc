<?php

class SlideController extends ApplicationController{
  var $controller_layout = "admin";
  var $before_filter = array("authenticate_user");
  
  function index() {
    if(is_numeric($this->initial["currentPage"]) && $this->initial["currentPage"] > 0){
      return render();
    }else{
      return renderError('404');
    }
  }
  function slide_list(){
    $list= array();
    $slides = Slide::all();
    foreach ($slides as $slide) {
      $d = strtotime($slide->created_date)*1000;
      $temp = array();
      $temp["publishDate"] = $d;
      $temp["disabled"] = ($slide->disabled == 0 ? false : true);
      $temp["id"] = $slide->id;
      $temp["title"] = $slide->title;
      $temp["trash"] = ($slide->trash == 0 ? false : true);
      $temp["imageLeft"] = Assets::find($slide->leftImage)->file["thumb"]->to_absolute_url();
      $temp["imageRight"] = Assets::find($slide->rightImage)->file["thumb"]->to_absolute_url();
      array_push($list,$temp);
    }
    return renderJson($list);
  }
  function new_slide() {
    return render();
  }

  function create(){
    $slide = new Slide();
    $slide->title = $this->params['title'];
    $slide->content = $this->params['content'];
    $slide->leftImage = $this->params['imgLeft'];
    $slide->rightImage = $this->params['imgRight'];
    $slide->disabled = ($this->params['disabled'] == "true" ? 1 : 0);
    if($this->params['publishDate']!=null){
      $slide->publishDate = $this->params['publishDate'];
    }
     if($this->params['endDate']!=null){
      $slide->endDate = $this->params['endDate'];
    }
    $slide->created_date = "now()";
    $slide->save();
    return renderJson(array("success"=>true));
  }

  function edit_slide() {
    $slide = Slide::find($this->params['id']);
    $data = array(
      "title" => $slide->title,
      "content" => $slide->content,
      "disabled" => ($slide->disabled==1) ? true : false,
      "imgLeft" => $slide->leftImage,
      "imgRight" => $slide->rightImage,
      "previewLeft" => Assets::find($slide->leftImage)->file["medium"]->to_absolute_url(),
      "previewRight" => Assets::find($slide->rightImage)->file["medium"]->to_absolute_url(),
      "endDate" => strtotime($slide->endDate)*1000,
      "publishDate" => strtotime($slide->publishDate)*1000
    );
     if($slide->endDate=='0000-00-00 00:00:00'){
      unset($data['endDate']);
    }

    if($slide->publishDate=='0000-00-00 00:00:00'){
      unset($data['publishDate']);
    }
    $this->initial = $data;

    return render();
  }

  function update(){
    $slide = Slide::find($this->params['post']['id']);
    $slide->title = $this->params['title'];
    $slide->content = $this->params['content'];
    $slide->disabled = ($this->params['disabled'] == "true" ? 1 : 0);
    $slide->leftImage = $this->params['imgLeft'];
    $slide->rightImage = $this->params['imgRight'];
    if($this->params['publishDate']!=""){
      $slide->publishDate = $this->params['publishDate'];
    }else{
      $slide->publishDate = "";
    }
     if($this->params['endDate']!=""){
      $slide->endDate = $this->params['endDate'];
    }else{
      $slide->endDate = "";
    }
    $slide->save();
    return renderJson(array("success"=>true));
  }

  function delete_slide(){
    foreach ($_POST['ids'] as $id) {
      $slide = Slide::find($id);
      switch ($_POST['action']) {
        case 'trash':
          $slide->trash = true;
          $slide->save();
          break;

        case 'undo':
          $slide->trash = false;
          $slide->save();
          break;

        case 'delete':
          $slide->delete();
          break;

        default:
          break;
      }
    }
    return renderJson(array("success"=>true));
  }

}
?>