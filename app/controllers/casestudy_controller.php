<?php
  class CasestudyController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      $this->categories = Category::all_with_quantity("case");
      $this->casesAll = Cases::all_array(($this->params["category"] ? $this->params["category"] : null),null,true);
      $this->viewSwich = true;
      $this->filter = true;
      $this->cases = $this->paginate_records(Cases::all_array($_GET['category'], $_GET['tag'],true));
      return render();
    }
    function show(){
      $this->case = Cases::get_case($this->params['id']);
      if($this->case == null)return renderError("404");
      $this->breadcrumb_title = $this->case["title"];
      $this->social_share_description = strip_tags($this->case["content"]);
      $this->social_share_image = ($this->case["imgs"][0] ? $this->case["imgs"][0]->file["large"]->to_absolute_url() : "");
      return render();
    }
  }
?>