<?php

class CaseController extends ApplicationController{
  var $controller_layout = "admin";
  var $before_filter = array("authenticate_user");

  function index() {
    $this->initial = array(
      "categorys" => Category::all_with_quantity("case"),
      "currentPage" =>  ($this->params["page_no"] ==  null ? 1 : $this->params["page_no"])
    );
    if(is_numeric($this->initial["currentPage"]) && $this->initial["currentPage"] > 0){
      return render();
    }else{
      return renderError('404');
    }
  }
  function case_list(){
    $list = Cases::all_array();
    return renderJson($list);
  }
  function new_case() {
    return render();
  }
  function create(){
    $case = new Cases();
    $case->title = $this->params['title'];
    $case->content = $this->params['content'];
    $case->location = $this->params['location'];
    $case->disabled = ($this->params['disabled'] == "true" ? 1 : 0);
    $case->top = ($this->params['top'] == "true" ? 1 : 0);
    $case->hot = ($this->params['hot'] == "true" ? 1 : 0);
    if($this->params['publishDate']!=null){
      $case->publishDate = $this->params['publishDate'];
    }
    if($this->params['endDate']!=null){
      $case->endDate = $this->params['endDate'];
    }
    $case->created_date = date('Y-m-d-h-m-s');

    $case->save();
    $this->add_relations($case);

    $case->add_relation("category",$this->params['category']);
    return renderJson(array("success"=>true));
  }
  function edit_case() {
    $case = Cases::find($this->params['id']);
    $links = [];
    foreach ($case->links_relation_ids as $link_id) {
      $link = Links::find($link_id);
      array_push($links, array('url'=>$link->url, 'text'=>$link->name));
    }
    $tags = [];
    foreach ($case->tags_relation_ids as $tag_id) {
      array_push($tags, (string)$tag_id);
    }
    $articles = [];
    foreach ($case->articles_relation_ids as $article_id) {
      array_push($articles, (string)$article_id);
    }
    $products = [];
    foreach ($case->products_relation_ids as $product_id) {
      array_push($products, (string)$product_id);
    }
    $preview = "";
    if($case->img){
      $preview = '/'.Assets::find($case->img)->file['medium']->path;
    }

    $data = array(
      "title" => $case->title,
      "content" => $case->content,
      "category" => (string)$case->category_relation_ids[0],
      "tag" => $tags,
      "disabled" => ($case->disabled==1 ? true : false),
      "top" => ($case->top==1 ? true : false),
      "hot" => ($case->hot==1 ? true : false),
      "publishDate" => strtotime($case->publishDate)*1000,
      "endDate" => strtotime($case->endDate)*1000,
      // "img" => $case->img,
      "img" => array(1, 9),
      "location" => $case->location,
      // "preview" => $preview,
      "preview" => array('/files/assets/1/small/l_stone01.jpg', '/files/assets/9/small/l_stone09.jpg'),
      "product" => $products,
      "Article" => $articles,
      "link" => $links
    );

    if($case->endDate=='0000-00-00 00:00:00'){
      unset($data['endDate']);
    }
    
    if($case->publishDate=='0000-00-00 00:00:00'){
      unset($data['publishDate']);
    }

    $this->initial = $data;

    return render();
  }
  function update(){
    $case = Cases::find($_POST['id']);
    $case->title = $this->params['title'];
    $case->content = $this->params['content'];
    $case->location = $this->params['location'];
    $case->disabled = ($this->params['disabled'] == "true" ? 1 : 0);
    $case->top = ($this->params['top'] == "true" ? 1 : 0);
    $case->hot = ($this->params['hot'] == "true" ? 1 : 0);
    if($this->params['publishDate']!=""){
      $case->publishDate = $this->params['publishDate'];
    }else{
      $case->publishDate = "";
    }
    if($this->params['endDate']!=""){
      $case->endDate = $this->params['endDate'];
    }else{
      $case->endDate = "";
    }

    $case->query("UPDATE `cases_category_mvcrelation` SET `category_id` = '{$this->params['category']}' WHERE `cases_id` = {$case->id};");

    $this->remove_relations($case);
    $case->save();
    $this->add_relations($case);
    return renderJson(array("success"=>$case ));
  }

  function delete_case(){
    foreach ($_POST['ids'] as $id) {
      $case = Cases::find($id);
      switch ($_POST['action']) {
        case 'trash':
          $case->trash = true;
          $case->save();
          break;

        case 'undo':
          $case->trash = false;
          $case->save();
          break;

        case 'delete':
          $case->delete_relation("category",$case->category_relation_ids[0]);
          $this->remove_relations($case);
          $case->delete();
          break;

        default:
          break;
      }
    }
    return renderJson(array("success"=>$case->trash));
  }
  function add_relations($case){
    $case->add_relation("category",$this->params['category']);

    if($this->params['link']!=null){
      foreach ($this->params['link'] as $link) {
        $l = new Links(array("name" => $link['text'],"url" => $link['url']));
        $l->save();
        $case->add_relation("links",$l);
      }
    }

    if($this->params[tag]!=null){
      foreach ($this->params[tag] as $tag_id) {
        $case->add_relation("tags",$tag_id);
      }
    }

    if($this->params[product]!=null){
      foreach ($this->params[product] as $products_id) {
        $case->add_relation("products",$products_id);
      }
    }

    if($this->params['article']!=null){
      foreach ($this->params['article'] as $article_id) {
        $case->add_relation("articles",$article_id);
      }
    }

    if($this->params['img']!=null){
      foreach ($this->params['img'] as $img) {
        $case->add_relation("assets",$img);
      }
    }
  }

  function remove_relations($case){
    if($case->links_relation_ids!=null){
        foreach ($case->links_relation_ids as $link_id) {
          $link = Links::find($link_id);
          $link->delete();
          $case->delete_relation("links",$link_id);
        }
      }

      if($case->tags_relation_ids!=null){
        foreach ($case->tags_relation_ids as $tag_id) {
          $case->delete_relation("tags",$tag_id);
        }
      }

      if($case->products_relation_ids!=null){
        foreach ($case->products_relation_ids as $products_id) {
          $case->delete_relation("products",$products_id);
        }
      }

      if($case->articles_relation_ids!=null){
        foreach ($case->articles_relation_ids as $article_id) {
          $case->delete_relation("articles",$article_id);
        }
      }
  }
}
?>