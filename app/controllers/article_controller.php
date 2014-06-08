<?php

class ArticleController extends ApplicationController{
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
  function article_list(){
    $list = Articles::all_array();
    return renderJson($list);
  }
  function new_article() {
    return render();
  }

  function create(){
    $article = new Articles();
    $article->title = $this->params['title'];
    $article->content = $this->params['content'];
    $article->disabled = ($this->params['disabled'] == "false" ? 1 : 0);
    if($this->params['date']!=null){
      $this->params['date'] = str_replace(" GMT+0800 (CST)", "", $this->params['date']);
      $this->params['date'] = str_replace(explode(' ',$this->params['date'])[0]." ", "", $this->params['date']);
      $article->date = gmdate('Y-m-d', strtotime($this->params['date']));
    }
    $article->created_date = date('Y-m-d');

    $article->save();
    $this->add_relations($article);
    
    $article->add_relation("category",$this->params['category']);
    return renderJson(array("success"=>true));
  }

  function edit_article() {
    $article = Articles::find($this->params['id']);
    $links = [];
    foreach ($article->links_relation_ids as $link_id) {
      $link = Links::find($link_id);
      array_push($links, array('url'=>$link->url, 'text'=>$link->name));
    }
    $tags = [];
    foreach ($article->tags_relation_ids as $tag_id) {
      array_push($tags, (string)$tag_id);
    }

    $data = array(
      "title" => $article->title,
      "content" => $article->content,
      "category" => (string)$article->category_relation_ids[0],
      "tag" => $tags,
      "disabled" => $article->disabled,
      "date" => strtotime($article->date)*1000,
      "img" => $article->img,
      "product" => $article->products_relation_ids,
      "case" => $article->cases_relation_ids,
      "link" => $links
    );

    if($article->date=='0000-00-00 00:00:00'){
      unset($data['date']);
    }
    
    $this->initial = $data;

    return render();
  }

  function update(){
    $article = Articles::find($_POST['id']);
    $article->title = $this->params['title'];
    $article->content = $this->params['content'];
    $article->disabled = ($this->params['disabled'] == "false" ? 1 : 0);
    if($this->params['date']!=""){
      $this->params['date'] = str_replace(" GMT+0800 (CST)", "", $this->params['date']);
      $this->params['date'] = str_replace(explode(' ',$this->params['date'])[0]." ", "", $this->params['date']);
      $article->date = gmdate('Y-m-d', strtotime($this->params['date']));
    }else{
      $article->date = "";
    }

    $this->remove_relations($article);
    $article->save();
    $this->add_relations($article);
    return renderJson(array("success"=>true ));
  }

  function delete_article(){
    foreach ($_POST['ids'] as $id) {
      $article = Articles::find($id);
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
      
    if($this->params[tag]!=null){
      foreach ($this->params[tag] as $tag_id) {
        $article->add_relation("tags",$tag_id);
      }
    }
    
    if($this->params[product]!=null){
      foreach ($this->params[product] as $products_id) {
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
  }
}
?>