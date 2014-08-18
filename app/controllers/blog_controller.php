<?php
  class BlogController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      $this->categories = Category::all_with_quantity("article");
      $this->articlesAll = Articles::all_array(null,true);
      $this->viewSwich = true;
      $this->filter = true;
      if($_GET['category']){
        $this->articles = Articles::all_array
        ($_GET['category'],true);
      }else{
        $this->articles = Articles::all_array(null,true);
      }

      return render();
    }
    function show(){
      $this->article = Articles::get_article($this->params['id']);
      if($this->article['img']){
        $this->img = Assets::find($this->article['img'])->file['original'];
      }
      return render();
    }
  }
?>