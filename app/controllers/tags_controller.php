<?php

class TagsController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $this->tags = Tags::all_with_quantity();
    return render();
  }

  function new_tag(){
    $tag= new Tags(array("name"=>$this->params['post']['value']));
    $tag->save();
    return renderJson(array('id' => $tag->id));
  }

  function edit_tag(){
    $tag = Tags::find($this->params['post']['id']);
    $tag->update_values(array('name'=>$this->params['post']['value']));
    return renderJson([]);
  }

  function delete_tag(){
    $tag = Tags::find($this->params['post']['id']);
    $tag->delete();
    return renderJson([]); 
  }
}
?>