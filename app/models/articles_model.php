<?php

class Articles extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function all_array(){
      $articles = self::query_db("SELECT a.id, a.title, UNIX_TIMESTAMP(a.publishDate)*1000 as `publishDate`, UNIX_TIMESTAMP(a.endDate)*1000 as 'endDate', a.disabled, a.trash, a.top, a.hot, a.created_date, (SELECT category_id FROM articles_category_mvcrelation WHERE articles_id = a.id) as category FROM articles a");
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