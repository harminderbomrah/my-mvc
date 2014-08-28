<?php

class Products extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function products_for_home(){
      $products = self::query_db("SELECT A.id,A.title,A.created_date,A.img,B.name AS `category` FROM `products` AS `A`, `category` AS `B`, `products_category_mvcrelation` AS `C` WHERE A.id = C.products_id AND C.category_id = B.id ORDER BY `created_date` DESC LIMIT 3");
      if($products==null){
        $products = [];
      }else{
        foreach ($products as $key=>$product) {
          $products[$key]['date'] = strftime("%b %d, %Y",strtotime($products[$key]['created_date']));
          $products[$key]["img"] = '/'.Assets::find(array_rand(Products::find($product['id'])->assets_relation_ids,1))->file['large']->path;
        }
      }
      return $products;
    }

    public static function all_with_quantity(){
      $cases = self::query_db("SELECT a.id, a.title FROM products a");
      return $cases;
    }


    public static function all_array($category=null, $tag=null, $frontend=false){
      if($category!=null) $category_filter = "AND B.category_id = {$category}";
      if($tag!=null) $tag_filter = "AND A.id = D.products_id AND D.tags_id={$tag}";
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
          category C,
          products_tags_mvcrelation D
        WHERE 
          A.id = B.products_id AND C.id=B.category_id {$category_filter} {$tag_filter} {$trash_filter} GROUP BY A.id");
      if($products==null){
        $products = [];
      }else{
        foreach ($products as $key => $product) {
          
          $products[$key]['tags'] = Tags::query_db("SELECT * FROM tags WHERE id IN (SELECT tags_id FROM products_tags_mvcrelation WHERE products_id = '{$product['id']}')");
          $img = Tags::query_db("SELECT assets_id FROM products_assets_mvcrelation WHERE products_id = '{$product['id']}' LIMIT 0,1");
          $products[$key]['image'] = Assets::find($img[0]["assets_id"])->file["large"];
          
          if($products[$key]['tags']==null) $products[$key]['tags'] = [];

          $products[$key]['trash'] = ($product['trash']==1) ? true : false;
        }
      }
      return $products;
    }

    public static function get_product($id){
      $product = Products::find(($id));
      if($product == null) return null;
      $tags = [];
      foreach ($product->tags_relation_ids as $tag_id) {
        array_push($tags,Tags::find($tag_id));
      }

      $specs = [];
      foreach ($product->product_specs_relation_ids as $spec_id) {
        $spec = ProductSpecs::find($spec_id);
        array_push($specs, array('item'=>$spec->item, 'detail'=>$spec->detail) );
      }

      $related_articles_ids = self::query_db("SELECT 
                                                                            A.articles_id 
                                                                          FROM 
                                                                            articles_products_mvcrelation A, 
                                                                            articles B 
                                                                          WHERE  
                                                                            A.articles_id=B.id 
                                                                            AND B.trash = false 
                                                                            AND (publishDate<=NOW() OR publishDate=0)
                                                                            AND (endDate>NOW() OR endDate=0)
                                                                            AND A.products_id={$id}");
      $related_articles = [];


      if($related_articles_ids!=null){
        foreach ($related_articles_ids as $articles) {
          $article = Articles::get_article($articles['articles_id']);
          $img = ($article["img"] ? $article["img"]->file["small"] : null);
          $article['image'] = $img;
          $article['id'] = $articles['articles_id'];
          array_push($related_articles, $article);
        }
      }
  
      $related_cases_ids = self::query_db("SELECT 
                                                                            A.cases_id 
                                                                          FROM 
                                                                            cases_products_mvcrelation A, 
                                                                            cases B 
                                                                          WHERE  
                                                                            A.cases_id=B.id 
                                                                            AND B.trash = false 
                                                                            AND (publishDate<=NOW() OR publishDate=0)
                                                                            AND (endDate>NOW() OR endDate=0)
                                                                            AND A.products_id={$id}");
      $related_cases = [];
      if($related_cases_ids!=null){
        foreach ($related_cases_ids as $cases) {
          $case = Cases::get_case($cases['cases_id']);
          if($case != null){
            $img = ($case["imgs"] ? $case["imgs"][0]->file["small"] : "");
            $case['image'] = $img;
            $case['id'] = $cases['cases_id'];
            array_push($related_cases, $case);
          }
        }
      }
  
      $next_and_previous = self::query_db("SELECT (SELECT id FROM products WHERE id > A.id ORDER BY id ASC LIMIT 0, 1) AS next_id, (SELECT id FROM products WHERE id < A.id ORDER BY id DESC LIMIT 0, 1) AS previous_id FROM products A WHERE A.id = {$product->id}");

      return array(
        "title" => $product->title,
        "depiction" => $product->depiction,
        "assets_relation_ids" => $product->assets_relation_ids,
        "category" => Category::find($product->category_relation_ids[0])->name,
        "tags" => $tags,
        "specs" => $specs,
        "related_articles" => $related_articles,
        "related_cases" => $related_cases,
        "next_id" => $next_and_previous[0]["next_id"],
        "previous_id" => $next_and_previous[0]["previous_id"]
      );
    }


}

?>