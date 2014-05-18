<?php

class tagsController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $this->tags = array(
      array("id" => 134512, "name" => "Mamie Daniel", "quantity" => 5),
      array("id" => 683432, "name" => "Brewer Perez", "quantity" => 0),
      array("id" => 923741, "name" => "Grant Reid", "quantity" => 9),
      array("id" => 965728, "name" => "Russell Salazar", "quantity" => 4),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16)
    );
    return render();
  }
}
?>