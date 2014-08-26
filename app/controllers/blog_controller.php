<?php
  class BlogController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      $this->categories = Category::all_with_quantity("article");
      $this->articlesAll = Articles::all_array(null, null,true);
      $this->viewSwich = true;
      $this->filter = true;
      $this->articles =  $this->paginate_records(Articles::all_array($_GET['category'], $_GET['tag'],true));
      if($this->articles == null){
        return renderError("404");
      }else{
        return render();
      }
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