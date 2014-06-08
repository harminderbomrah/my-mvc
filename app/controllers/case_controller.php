<?php

class CaseController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $this->current_user->needs_authentication();

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
    $case->disabled = ($this->params['disabled'] == "false" ? 1 : 0);
    if($this->params['date']!=null){
      $this->params['date'] = str_replace(" GMT+0800 (CST)", "", $this->params['date']);
      $this->params['date'] = str_replace(explode(' ',$this->params['date'])[0]." ", "", $this->params['date']);
      $case->date = gmdate('Y-m-d', strtotime($this->params['date']));
    }
    $case->created_date = date('Y-m-d');
    
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

    $data = array(
      "title" => $case->title,
      "content" => $case->content,
      "category" => (string)$case->category_relation_ids[0],
      "tag" => $tags,
      "disabled" => $case->disabled,
      "date" => strtotime($case->date)*1000,
      "img" => $case->img,
      "product" => $case->products_relation_ids,
      "Article" => $case->article_relation_ids,
      "link" => $links
    );

    if($case->date=='0000-00-00 00:00:00'){
      unset($data['date']);
    }
    
    $this->initial = $data;

    return render();
  }
  function update(){
    $case = Cases::find($_POST['id']);
    $case->title = $this->params['title'];
    $case->content = $this->params['content'];
    $case->disabled = ($this->params['disabled'] == "false" ? 1 : 0);
    if($this->params['date']!=""){
      $this->params['date'] = str_replace(" GMT+0800 (CST)", "", $this->params['date']);
      $this->params['date'] = str_replace(explode(' ',$this->params['date'])[0]." ", "", $this->params['date']);
      $case->date = gmdate('Y-m-d', strtotime($this->params['date']));
    }else{
      $case->date = "";
    }

    $this->remove_relations($case);
    $case->save();
    $this->add_relations($case);
    return renderJson(array("success"=>true ));
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
    return renderJson(array("success"=>true));
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
  }
}
?>