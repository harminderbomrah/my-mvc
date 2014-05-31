<?php

class Tags extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function all_with_quantity(){
      $tags = self::all();

      $result = array();

      if($tags!=null){
        foreach($tags as $tag){
          $quantity = count($tag->articles_relation_ids);
          array_push($result, array('id'=>$tag->id, 'name'=>$tag->name, 'quantity'=>$quantity));
        }
      }
      return $result;
    }
}

?>