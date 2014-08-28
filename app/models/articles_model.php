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

    public static function all_array($category=null, $tag=null, $frontend=false){
      if($category!=null) $category_filter = "AND B.category_id = {$category}";
      if($tag!=null) $tag_filter = "AND A.id = C.articles_id AND C.tags_id={$tag}";
      if($frontend){
         $trash_filter = "AND A.trash = false AND (A.publishDate<=NOW() OR A.publishDate=0) AND (A.endDate>NOW() OR A.endDate=0)";
          $ordering = "ORDER BY A.top DESC, A.created_date DESC";
       }

      $articles = self::query_db("
        SELECT 
          A.id, 
          A.title, 
          A.content,
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
          articles_category_mvcrelation AS B,
          articles_tags_mvcrelation C
        WHERE 
          A.id = B.articles_id {$category_filter} {$tag_filter} {$trash_filter}
        GROUP BY
          A.id {$ordering}");
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
          $articles[$key]['content'] = $article["content"];
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
      if(!$article) return null;
      $tags = [];
      if($article->tags_relation_ids){
        foreach ($article->tags_relation_ids as $tag_id) {
          array_push($tags,Tags::find($tag_id)->name);
        }
      }

      $products = [];
      if($article->products_relation_ids){
        foreach ($article->products_relation_ids as $product_id) {
          $product = Products::find($product_id);
          if($product != null){
            array_push($products,array("title"=>$product->title, "id"=>$product->id, "category" => Category::find($product->category_relation_ids[0])->name, "image" => ($product->assets_relation_ids ? Assets::find($product->assets_relation_ids[0])->file["medium"] : null)));
          }
        }
      }

      $cases = [];
      if($article->cases_relation_ids){
        foreach ($article->cases_relation_ids as $case_id) {
          $case = Cases::find($case_id);
          if($case != null){
            array_push($cases,array("title"=>$case->title, "id"=>$case->id, "location" => $case->location, "date" => strftime("%b %d, %Y",strtotime(($case->publishDate == "0000-00-00 00:00:00" ? $case->created_date : $case->publishDate))), "image" => ($case->assets_relation_ids ? Assets::find($case->assets_relation_ids[0])->file["medium"] : null)));
          }
        }
      }

      $date = strftime("%b %d, %Y",strtotime(($article->publishDate == "0000-00-00 00:00:00" ? $article->created_date : $article->publishDate)));

      $links = [];
      if($article->links_relation_ids){
        foreach ($article->links_relation_ids as $link_id) {
          $link = Links::find($link_id);
          if($link != null){ 
            array_push($links,array("name"=>$link->name, "url"=>$link->url));
          }
        }
      }
      $next_and_previous = self::query_db("SELECT (SELECT id FROM articles WHERE id > A.id ORDER BY id ASC LIMIT 0, 1) AS next_id, (SELECT id FROM articles WHERE id < A.id ORDER BY id DESC LIMIT 0, 1) AS previous_id FROM articles A WHERE A.id = {$article->id}");

      return array(
        "id" => $article->id,
        "title" => $article->title,
        "content" => $article->content,
        "img" => ($article->img ? Assets::find($article->img) : null),
        "hot" => $article->hot,
        "top" => $article->top,
        "category" => ($article->category_relation_ids ? Category::find($article->category_relation_ids[0])->name : null),
        "tags" => $tags,
        "products" => $products,
        "cases" => $cases,
        "links" => $links,
        "date" => $date,
        "next_id" => $next_and_previous[0]["next_id"],
        "previous_id" => $next_and_previous[0]["previous_id"]
      );
    }


    public static function get_related_articles($id){
      $article = self::find($id);
      $related_articles = array();
      if(count($article->tags_relation_ids) > 0){
        foreach ($article->tags_relation_ids as $tagid) {
          $t = Tags::find($tagid);
          foreach ($t->articles_relation_ids as $aid) {
            if($aid != $article->id){
              array_push($related_articles, self::get_article($aid));
            }
            if(count($related_articles) == 4){
              break;
            }
          }
        }
      }

      if(count($related_articles) < 4){
          $c = Category::find($article->category_relation_ids[0]);
          foreach ($c->articles_relation_ids as $aid) {
            var_dump($aid);
            if($aid != $article->id){
              $a = self::get_article($aid);
              if($a != null){
                array_push($related_articles, $a);
              }
            }
            if(count($related_articles) == 4){
              break;
            }
          }
        }
        return $related_articles;
    }
}

?>