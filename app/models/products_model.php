<?php

class Products extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function all_with_quantity(){
      $cases = self::query_db("SELECT a.id, a.title FROM products a");
      return $cases;
    }

    public static function all_array($category=null, $frontend=false){
      if($category!=null) $category_filter = "AND B.category_id = {$category}";
      if($frontend) $trash_filter = "AND A.trash = false";

      $products = self::query_db("
        SELECT 
          A.id, 
          A.title AS `name`, 
          A.trash, 
          B.category_id AS `category`, 
          C.name AS `category_name` 
        FROM 
          products A, 
          products_category_mvcrelation B, 
          category C 
        WHERE 
          A.id = B.products_id AND C.id=B.category_id {$category_filter} {$trash_filter}");
      if($products==null){
        $products = [];
      }else{
        foreach ($products as $key => $product) {
          
          $products[$key]['tags'] = Tags::query_db("SELECT * FROM tags WHERE id IN (SELECT tags_id FROM products_tags_mvcrelation WHERE products_id = '{$product['id']}')");
          
          if($products[$key]['tags']==null) $products[$key]['tags'] = [];

          $products[$key]['trash'] = ($product['trash']==1) ? true : false;
        }
      }
      return $products;
    }

    public static function get_product($id){
      $product = Products::find(($id));

      $tags = [];
      foreach ($product->tags_relation_ids as $tag_id) {
        array_push($tags,Tags::find($tag_id));
      }

      $specs = [];
      foreach ($product->product_specs_relation_ids as $spec_id) {
        $spec = ProductSpecs::find($spec_id);
        array_push($specs, array('item'=>$spec->item, 'detail'=>$spec->detail) );
      }

      return array(
        "title" => $product->title,
        "depiction" => $product->depiction,
        "category" => Category::find($product->category_relation_ids[0])->name,
        "tag" => $tags,
        "specs" => $specs
      );
    }
}

?>