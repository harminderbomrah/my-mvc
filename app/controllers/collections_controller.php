<?php
  class CollectionsController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      $this->filter = true;
      $this->categories = Category::all_with_quantity("product");
      $this->products = $this->paginate_records(Products::all_array($_GET['category'], $_GET['tag'],true));
      if($this->products == null){
        return renderError("404");
      }else{
        return render();
      }
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