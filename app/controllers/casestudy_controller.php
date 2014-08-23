<?php
  class CasestudyController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      $this->categories = Category::all_with_quantity("case");
      $this->casesAll = Cases::all_array(null,true);
      $this->viewSwich = true;
      $this->filter = true;
      $this->cases = Cases::all_array($_GET['category'], $_GET['tag'],true);
      return render();
    }
    function show(){
      $this->case = Cases::get_case($this->params['id']);
      if($this->case['img']){
        $this->img = Assets::find($this->case['img'])->file['original'];
      }
      return render();
    }
  }
?>