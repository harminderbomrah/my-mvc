<?php

class Products extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    public static function all_array(){
      $products = self::query_db("SELECT A.id, A.title AS `name`, A.trash, B.category_id AS `category` FROM products A, products_category_mvcrelation B WHERE A.id = B.products_id ");
      if($products==null){
        $products = [];
      }
      return $products;
    }
}

?>