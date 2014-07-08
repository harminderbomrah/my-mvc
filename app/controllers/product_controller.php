<?php
  class ProductController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      $this->categories = Category::all_with_quantity("product");
      if($_GET['category']){
        $this->products = Products::all_array($_GET['category'],true);
      }else{
        $this->products = Products::all_array(null,true);
      }
      
      return render();
    }
    function show(){
      $this->product = Products::get_product($this->params['id']);
      return render();
    }
  }
?>