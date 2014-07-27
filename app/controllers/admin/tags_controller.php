<?php

class TagsController extends ApplicationController{
  var $controller_layout = "admin";
  var $before_filter = array("authenticate_user");
  
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
    if($this->params['action'] == 'delete'){
      $tag = Tags::find($this->params['id']);
      $tag->delete();
    }elseif ($this->params['action'] == 'replace') {
      $tag = Tags::find($this->params['oldID']);
      $new_tag = $this->params['newID'];

      $types = ['articles','products','cases'];

      foreach ($types as $type) {
        $table = $type . "_tags_mvcrelation";
        Tags::query_db("UPDATE `{$table}` SET `tags_id` = '{$new_tag}' WHERE `tags_id` = {$tag->id};");
      }

      $tag->delete();
    }

    return renderJson([]); 
  }
}
?>