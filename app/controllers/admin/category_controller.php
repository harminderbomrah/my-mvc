<?php

class CategoryController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $this->category = Category::all_with_quantity($this->params['type']);
    return render(array('view'=>'admin/'.$this->params['type'].'/category'));
  }

  function new_category(){
    $cate= new Category(array("name"=>$this->params['post']['value'], 'type'=>$this->params['type']));
    $cate->save();
    return renderJson(array('id' => $cate->id));
  }

  function edit_category(){
    $cate = Category::find($this->params['post']['id']);
    $cate->update_values(array('name'=>$this->params['post']['value']));
    return renderJson([]);
  }

  function delete_category(){
    $cate = Category::find($this->params['post']['id']);
    $cate->delete();
    return renderJson([]); 
  }
}
?>