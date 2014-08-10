<?php

class Category extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function all_with_quantity($type){
      $cates = self::find_by(array("type"=>$type));
      $result = array();

      if($cates!=null){
        foreach($cates as $cate){
          $field = "{$type}s_relation_ids";
          $quantity = count($cate->{$field});
          array_push($result, array('id'=>$cate->id, 'name'=>$cate->name, 'description'=>$cate->description, 'quantity'=>$quantity));
        }
      }
      return $result;
    }
}

?>