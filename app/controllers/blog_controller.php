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
      if($this->article["next_id"]){
        $this->next_article = Articles::get_article($this->article["next_id"]);
      }
      if($this->article["previous_id"]){
        $this->previous_article = Articles::get_article($this->article["previous_id"]);
      }
      $this->related_articles = Articles::get_related_articles($this->params['id']);
      $this->breadcrumb_title = $this->article["title"];
      $this->social_share_description = strip_tags($this->article["content"]);
      $this->social_share_image = ($this->img ? $this->img->to_absolute_url() : "");
      return render();
    }
  }
?>