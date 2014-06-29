<?php

class SlideController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $this->current_user->needs_authentication();

    $this->initial = array(
      "categorys" => Category::all_with_quantity("article"),
      "currentPage" =>  ($this->params["page_no"] ==  null ? 1 : $this->params["page_no"])
    );
    if(is_numeric($this->initial["currentPage"]) && $this->initial["currentPage"] > 0){
      return render();
    }else{
      return renderError('404');
    }
  }
  function slide_list(){
    // $list = Slides::all_array();
    $list = array(
      array(
        "created_date" => "2014-06-07 00:00:00",
        "date" => 1402099200000,
        "disabled" => false,
        "id" => "28",
        "title" => "trash",
        "trash" => true,
        "image" => "/public/file/slide/banner_img4.jpg"
      ),
      array(
        "created_date" => "2014-06-07 00:00:00",
        "date" => 1402099200000,
        "disabled" => false,
        "id" => "29",
        "title" => "aaaaa",
        "trash" => false,
        "image" => "/public/file/slide/banner_img4.jpg"
      ),
      array(
        "created_date" => "2014-06-07 00:00:00",
        "date" => 1402099200000,
        "disabled" => true,
        "id" => "30",
        "title" => "disabled",
        "trash" => false,
        "image" => "/public/file/slide/banner_img4.jpg"
      )
    );
    return renderJson($list);
  }
  function new_slide() {
    return render();
  }

  function create(){
    $article = new Slides();
    $article->title = $this->params['title'];
    $article->content = $this->params['content'];
    $article->disabled = ($this->params['disabled'] == "false" ? 1 : 0);
    $article->top = ($this->params['top'] == "true" ? 1 : 0);
    $article->hot = ($this->params['hot'] == "true" ? 1 : 0);
    if($this->params['date']!=null){
      $article->date = date("Y-m-d", $this->params['date']/1000);
    }
    $article->created_date = date('Y-m-d-h-m-s');

    $article->save();
    $this->add_relations($article);
    
    $article->add_relation("category",$this->params['category']);
    return renderJson(array("success"=>true));
  }

  function edit_slide() {
    $article = Slides::find($this->params['id']);
    $links = [];
    foreach ($article->links_relation_ids as $link_id) {
      $link = Links::find($link_id);
      array_push($links, array('url'=>$link->url, 'text'=>$link->name));
    }
    $tags = [];
    foreach ($article->tags_relation_ids as $tag_id) {
      array_push($tags, (string)$tag_id);
    }
    $cases = [];
    foreach ($article->cases_relation_ids as $case_id) {
      array_push($cases, (string)$case_id);
    }
    $products = [];
    foreach ($article->products_relation_ids as $product_id) {
      array_push($products, (string)$product_id);
    }

    $data = array(
      "title" => $article->title,
      "content" => $article->content,
      "category" => (string)$article->category_relation_ids[0],
      "tag" => $tags,
      "disabled" => ($article->disabled==1) ? true : false,
      "top" => ($article->top==1) ? true : false,
      "hot" => ($article->hot==1) ? true : false,
      "date" => strtotime($article->date)*1000,
      "img" => $article->img,
      "product" => $products,
      "case" => $cases,
      "link" => $links
    );

    if($article->date=='0000-00-00 00:00:00'){
      unset($data['date']);
    }
    
    $this->initial = $data;

    return render();
  }

  function update(){
    $article = Slides::find($_POST['id']);
    $article->title = $this->params['title'];
    $article->content = $this->params['content'];
    $article->disabled = ($this->params['disabled'] == "true" ? 1 : 0);
    $article->top = ($this->params['top'] == "true" ? 1 : 0);
    $article->hot = ($this->params['hot'] == "true" ? 1 : 0);
    if($this->params['date']!=""){
      $article->date = date("Y-m-d", $this->params['date']/1000);
    }else{
      $article->date = "";
    }

    $this->remove_relations($article);
    $article->save();
    $this->add_relations($article);
    return renderJson(array("success"=>$article->disabled ));
  }

  function delete_slide(){
    foreach ($_POST['ids'] as $id) {
      $article = Slides::find($id);
      switch ($_POST['action']) {
        case 'trash':
          $article->trash = true;
          $article->save();
          break;

        case 'undo':
          $article->trash = false;
          $article->save();
          break;

        case 'delete':
          $article->delete_relation("category",$article->category_relation_ids[0]);
          $this->remove_relations($article);
          $article->delete();
          break;
        
        default:
          break;
      }
    }
    return renderJson(array("success"=>true));
  }

  function add_relations($article){
    $article->add_relation("category",$this->params['category']);

    if($this->params['link']!=null){
      foreach ($this->params['link'] as $link) {
        $l = new Links(array("name" => $link['text'],"url" => $link['url']));
        $l->save();
        $article->add_relation("links",$l);
      }
    }
      
    if($this->params["tag"]!=null){
      foreach ($this->params["tag"] as $tag_id) {
        $article->add_relation("tags",$tag_id);
      }
    }

    if($this->params['case']!=null){
      foreach ($this->params['case'] as $case_id) {
        $article->add_relation("cases",$case_id);
      }
    }
    
    if($this->params["product"]!=null){
      foreach ($this->params["product"] as $products_id) {
        $article->add_relation("products",$products_id);
      }
    }
  }

  function remove_relations($article){
    if($article->links_relation_ids!=null){
        foreach ($article->links_relation_ids as $link_id) {
          $link = Links::find($link_id);
          $link->delete();
          $article->delete_relation("links",$link_id);
        }
      }
      
      if($article->tags_relation_ids!=null){
        foreach ($article->tags_relation_ids as $tag_id) {
          $article->delete_relation("tags",$tag_id);
        }
      }
      
      if($article->products_relation_ids!=null){
        foreach ($article->products_relation_ids as $products_id) {
          $article->delete_relation("products",$products_id);
        }
      }

      if($article->cases_relation_ids!=null){
        foreach ($article->cases_relation_ids as $case_id) {
          $article->delete_relation("cases",$case_id);
        }
      }
  }
}
?>