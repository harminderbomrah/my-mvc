<?php

class ProductController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $this->initial = array(
      "categorys" => array(
        array("id" => 1000, "name" => "Mamie Daniel", "quantity" => 5),
        array("id" => 1001, "name" => "Brewer Perez", "quantity" => 0),
        array("id" => 1002, "name" => "Grant Reid", "quantity" => 9),
        array("id" => 1003, "name" => "Russell Salazar", "quantity" => 4),
        array("id" => 1004, "name" => "Hello World", "quantity" => 10),
        array("id" => 1004, "name" => "Melody Sosa", "quantity" => 16)
      ),
      "currentPage" =>  ($this->params["page_no"] ==  null ? 1 : $this->params["page_no"])
    );
    // var_dump($this->initial);
    if(is_numeric($this->initial["currentPage"]) && $this->initial["currentPage"] > 0){
      return render();
    }else{
      return renderError('404');
    }
  }
  function new_product() {
    return render();
  }
  function edit_product() {
    $this->initial = array(
      "title" => "Test Title",
      "category" => 923741,
      "tag" => ["6de8262c", "bed988a7", "f59f2f4c", "97ed22df", "ea3bc5b5"]
    );
    return render();
  }
  function category() {
    $this->category = array(
      array("id" => 134512, "name" => "Mamie Daniel", "quantity" => 5),
      array("id" => 683432, "name" => "Brewer Perez", "quantity" => 0),
      array("id" => 923741, "name" => "Grant Reid", "quantity" => 9),
      array("id" => 965728, "name" => "Russell Salazar", "quantity" => 4),
      array("id" => 103404, "name" => "Hello World", "quantity" => 10),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16)
    );
    return render();
  }
}
?>