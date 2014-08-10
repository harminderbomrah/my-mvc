<?php

class Articles extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function articles_for_home(){
      $articles = self::query_db("SELECT A.id,A.title,A.publishDate,A.created_date,A.img,B.name AS `category` FROM `articles` AS `A`, `category` AS `B`, `articles_category_mvcrelation` AS `C` WHERE A.id = C.articles_id AND C.category_id = B.id ORDER BY `top` DESC, `hot` DESC, `publishDate` DESC, `created_date` DESC LIMIT 3");
      if($articles==null){
        $articles = [];
      }else{
        foreach ($articles as $key=>$article) {
          if($article['publishDate']=="0000-00-00 00:00:00"){
            $articles[$key]['date'] = strftime("%b %d, %Y",strtotime($articles[$key]['created_date']));
          }else{
            $articles[$key]['date'] = strftime("%b %d, %Y",strtotime($article['publishDate']));
          }
          $articles[$key]["img"] = ($article["img"] ? '/'.Assets::find($article["img"])->file['large']->path : "");
        }
      }
      return $articles;
    }

    public static function all_array($category=null, $frontend=false){
      if($category!=null) $category_filter = "AND B.category_id = {$category}";
      if($frontend) $trash_filter = "AND A.trash = false";

      $articles = self::query_db("
        SELECT 
          A.id, 
          A.title, 
          UNIX_TIMESTAMP(A.publishDate)*1000 AS `publishDate`,    
          UNIX_TIMESTAMP(A.endDate)*1000 AS 'endDate', 
          A.disabled, 
          A.trash, 
          A.top, 
          A.hot, 
          A.img,
          A.created_date,
          B.category_id AS category
        FROM 
          articles AS A, 
          articles_category_mvcrelation AS B 
        WHERE 
          A.id = B.articles_id {$category_filter} {$trash_filter}
        GROUP BY
          A.id");
      if($articles==null){
        $articles = [];
      }else{
        foreach ($articles as $key=>$article) {

          $articles[$key]['tags'] = self::query_db("SELECT * FROM tags WHERE id IN (SELECT tags_id FROM articles_tags_mvcrelation WHERE articles_id = '{$article['id']}')");

          if($articles[$key]['tags']==null) $articles[$key]['tags'] = [];

          if($article['publishDate']=="0"){
            $articles[$key]['publishDate'] = strtotime($articles[$key]['created_date'])*1000;
          }
          $img = ($article["img"] ? Assets::find($article["img"])->file["large"] : "");
          $articles[$key]['image'] = $img;
          $articles[$key]['trash'] = ($article['trash']==1) ? true : false;
          $articles[$key]['top'] = ($article['top']==1) ? true : false;
          $articles[$key]['hot'] = ($article['hot']==1) ? true : false;
          $articles[$key]['disabled'] = ($article['disabled']=="1") ? true : false;
        }
      }
      return $articles;
    }

    public static function get_article($id){
      $article = Articles::find($id);

      $tags = [];
      foreach ($article->tags_relation_ids as $tag_id) {
        array_push($tags,Tags::find($tag_id)->name);
      }

      $products = [];
      foreach ($article->products_relation_ids as $product_id) {
        $product = Products::find($product_id);
        array_push($products,array("title"=>$product->title, "id"=>$product->id));
      }

      $cases = [];
      foreach ($article->cases_relation_ids as $case_id) {
        $case = Cases::find($case_id);
        array_push($cases,array("title"=>$case->title, "id"=>$case->id));
      }

      $links = [];
      foreach ($article->links_relation_ids as $link_id) {
        $link = Links::find($link_id);
        array_push($links,array("name"=>$link->name, "url"=>$link->url));
      }

      return array(
        "title" => $article->title,
        "content" => $article->content,
        "img" => $article->img,
        "hot" => $article->hot,
        "top" => $article->top,
        "category" => Category::find($article->category_relation_ids[0])->name,
        "tags" => $tags,
        "products" => $products,
        "cases" => $cases,
        "links" => $links
      );
    }
}

?>