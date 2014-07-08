<?php

class Articles extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function all_array(){
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
          A.created_date,
          B.category_id AS category
        FROM 
          articles AS A, 
          articles_category_mvcrelation AS B 
        WHERE 
          A.id = B.articles_id
        GROUP BY
          A.id");
      if($articles==null){
        $articles = [];
      }else{
        foreach ($articles as $key=>$article) {
          if($article['publishDate']=="0"){
            $articles[$key]['publishDate'] = strtotime($articles[$key]['created_date'])*1000;
          }
          $articles[$key]['trash'] = ($article['trash']==1) ? true : false;
          $articles[$key]['top'] = ($article['top']==1) ? true : false;
          $articles[$key]['hot'] = ($article['hot']==1) ? true : false;
          $articles[$key]['disabled'] = ($article['disabled']=="1") ? true : false;
        }
      }
      return $articles;
    }
}

?>