<?php
  class CaseController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      $this->categories = Category::all_with_quantity("case");
      if($_GET['category']){
        $this->cases = Cases::all_array
        ($_GET['category'],true);
      }else{
        $this->cases = Cases::all_array(null,true);
      }
      
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