<?php
  class CollectionsController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      $this->filter = true;
      $this->categories = Category::all_with_quantity("product");
      $this->products = $this->paginate_records(Products::all_array($_GET['category'], $_GET['tag'],true));
      return render();
    }
    
    function show(){
      $this->product = Products::get_product($this->params['id']);
      if($this->product == null) return renderError("404");
      $this->breadcrumb_title = $this->product["title"];
      $this->social_share_description = strip_tags($this->product["depiction"]);
      
      $imgs = array();
      foreach ($this->product['assets_relation_ids'] as $asset_id) {
        array_push($imgs, Assets::find($asset_id)->file['original']);
      }
      $this->imgs = $imgs;
      $this->social_share_image = ($imgs[0] ? $imgs[0]->to_absolute_url() : "");
      return render();
    }
  }
?>