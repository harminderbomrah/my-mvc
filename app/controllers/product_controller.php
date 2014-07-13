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
      $imgs = array();
      foreach ($this->product['assets_relation_ids'] as $asset_id) {
        array_push($imgs, Assets::find($asset_id)->file['original']);
      }
      $this->imgs = $imgs;
      return render();
    }
  }
?>