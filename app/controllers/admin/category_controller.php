<?php

class CategoryController extends ApplicationController{
  var $controller_layout = "admin";
  var $before_filter = array("authenticate_user");
  
  function index() {
    $this->category = Category::all_with_quantity($this->params['type']);
    return render(array('view'=>'admin/'.$this->params['type'].'/category'));
  }

  function new_category(){
    $cate= new Category(array("name"=>$this->params['post']['name'], "description"=>$this->params['post']['description'], 'type'=>$this->params['type']));
    $cate->save();
    return renderJson(array('id' => $cate->id));
  }

  function edit_category(){
    $cate = Category::find($this->params['post']['id']);
    $cate->update_values(array('name'=>$this->params['post']['name'], "description"=>$this->params['post']['description']));
    return renderJson([]);
  }

  function delete_category(){
    $type = $this->params["type"];

    if($this->params['action'] == 'delete') {
      $cate = Category::find($_POST['id']);
      $cate->delete();
    } elseif ($this->params['action'] == 'replace') {
      $cate = Category::find($this->params['oldID']);
      $new_cate = $this->params['newID'];

      $table = $type . "s_category_mvcrelation";

      Category::query_db("UPDATE `{$table}` SET `category_id` = '{$new_cate}' WHERE `category_id` = {$cate->id};");

      $cate->delete();
    }

    return renderJson([]); 
  }
}
?>