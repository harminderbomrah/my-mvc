<?php

class Articles extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function all_array(){
      $articles = self::query_db("SELECT a.id, a.title, UNIX_TIMESTAMP(a.date)*1000 as `date`, a.disabled, a.trash, a.created_date, (SELECT category_id FROM articles_category_mvcrelation WHERE articles_id = a.id) as category FROM articles a");
      if($articles==null){
        $articles = [];
      }else{
        foreach ($articles as $key=>$article) {
          if($article['date']=="0"){
            $articles[$key]['date'] = strtotime($articles[$key]['created_date'])*1000;
          }
        }
      }
      return $articles;
    }
}

?>