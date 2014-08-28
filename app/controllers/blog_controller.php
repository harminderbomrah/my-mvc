<?php
  class BlogController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      $this->categories = Category::all_with_quantity("article");
      $this->articlesAll = Articles::all_array(null, null,true);
      $this->viewSwich = true;
      $this->filter = true;
      $this->articles =  $this->paginate_records(Articles::all_array($_GET['category'], $_GET['tag'],true));
      return render();
    }
    function show(){
      $this->article = Articles::get_article($this->params['id']);
      if($this->article == null) return renderError("404");
      $this->breadcrumb_title = $this->article["title"];
      $this->social_share_description = strip_tags($this->article["content"]);
      if($this->article['img']){
        $this->img = Assets::find($this->article['img'])->file['original'];
      }
       $this->social_share_image = ($this->img ? $this->img->to_absolute_url() : "");
      return render();
    }
  }
?>