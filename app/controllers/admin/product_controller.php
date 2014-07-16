<?php

class ProductController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $this->initial = array(
      "categorys" => Category::all_with_quantity("product"),
      "currentPage" =>  ($this->params["page_no"] ==  null ? 1 : $this->params["page_no"])
    );
    if(is_numeric($this->initial["currentPage"]) && $this->initial["currentPage"] > 0){
      return render();
    }else{
      return renderError('404');
    }
  }
  function product_list(){
    $list = Products::all_array();
    return renderJson($list);
  }
  function new_product() {
    return render();
  }
  function create(){
    $product = new Products();
    $product->title = $this->params['title'];
    $product->depiction = $this->params['depiction'];
    $product->created_date = date('Y-m-d');
    $product->save();
    $this->add_relations($product);

    return renderJson(array('success'=>'ok'));
  }
  function edit_product() {
    $product = Products::find(($this->params['id']));
    $tags = [];
    foreach ($product->tags_relation_ids as $tag_id) {
      array_push($tags, (string)$tag_id);
    }
    $specs = null;
    foreach ($product->product_specs_relation_ids as $spec_id) {
      $spec = ProductSpecs::find($spec_id);
      $specs["{$spec->item}"]=$spec->detail;
    }

    $preview = [];
    foreach ($product->assets_relation_ids as $asset_id) {
      $asset = Assets::find($asset_id);
      array_push($preview, '/'.$asset->file['medium']->path);
    }

    $this->initial = array(
      "title" => $product->title,
      "depiction" => $product->depiction,
      "category" => (string)$product->category_relation_ids[0],
      "img" => $product->assets_relation_ids,
      "preview" => $preview,
      "tag" => $tags,
      "specs" => $specs
    );
    return render();
  }

  function update() {
    $product = Products::find(($_POST['id']));
    $product->title = $this->params['title'];
    $product->depiction = $this->params['depiction'];
    $this->remove_relations($product);
    $product->save();
    $this->add_relations($product);

    return renderJson(array("success"=>$this->params['specs'] ));
  }

  function delete_product(){
    foreach ($_POST['ids'] as $id) {
      $product = Products::find($id);
      switch ($_POST['action']) {
        case 'trash':
          $product->trash = true;
          $product->save();
          break;

        case 'undo':
          $product->trash = false;
          $product->save();
          break;

        case 'delete':
          $product->delete_relation("category",$product->category_relation_ids[0]);
          $this->remove_relations($product);
          $product->delete();
          break;

        default:
          break;
      }
    }
    return renderJson(array("success"=>true));
  }

  function add_relations($product){
    $product->add_relation("category",$this->params['category']);

    if($this->params['tag']!=null){
      foreach ($this->params[tag] as $tag_id) {
        $product->add_relation("tags",$tag_id);
      }
    }

    if($this->params['specs']!=null){
      foreach ($this->params['specs'] as $key => $spec) {
        $s = new ProductSpecs(array("item" => $key,"detail" => $spec));
        $s->save();
        $product->add_relation("product_specs",$s);
      }
    }

    if($this->params['img']!=null){
      foreach ($this->params['img'] as $img) {
        $product->add_relation("assets",$img);
      }
    }
  }

  function remove_relations($product){
    if($product->tags_relation_ids!=null){
      foreach ($product->tags_relation_ids as $tag_id) {
        $product->delete_relation("tags",$tag_id);
      }
    }

    if($product->product_specs_relation_ids!=null){
      foreach ($product->product_specs_relation_ids as $spec_id) {
        $spec = ProductSpecs::find($spec_id);
        $spec->delete();
        $product->delete_relation("product_specs",$spec_id);
      }
    }

    if($product->assets_relation_ids!=null){
      foreach ($product->assets_relation_ids as $asset_id) {
        $product->delete_relation("assets",$asset_id);
      }
    }
  }
}
?>