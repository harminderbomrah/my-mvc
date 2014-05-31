<?php

class ArticleController extends ApplicationController{
  var $controller_layout = "admin";
  function index() {
    $this->initial = array(
      "categorys" => array(
        array("id" => 134512, "name" => "Mamie Daniel", "quantity" => 5),
        array("id" => 683432, "name" => "Brewer Perez", "quantity" => 0),
        array("id" => 923741, "name" => "Grant Reid", "quantity" => 9),
        array("id" => 965728, "name" => "Russell Salazar", "quantity" => 4),
        array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16)
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
  function new_article() {
    return render();
  }
  function edit_article() {
    $this->initial = array(
      "title" => "Test Title",
      "content" => '<div class="adfe"><ul><li>1</li><li>2</li><li>3</li><li>4</li><li>5</li><li>6</li><li>7</li><li>8</li></ul></div>',
      "category" => 923741,
      "tag" => ["6de8262c", "bed988a7", "f59f2f4c", "97ed22df", "ea3bc5b5"],
      "disabled" => false,
      "date" => 1894324462454,
      "img" => "/public/259601353_a67f21819740.jpg",
      "product" => ["5e6761ca-174f-4438-8577-df16f8981adf", "0a246b03-e385-4342-945f-3025e577068c", "4f8bf3c6-ba80-45a9-8cb1-77fe9bac1742"],
      "case" => ["e2559a12-b36f-4a85-900e-d3e64be0bc1e", "0bb80a85-1c20-472a-b578-ce78132f572d"],
      "link" => [
        [
          "url" => "http://www.google.com",
          "text" => "Google"
        ],
        [
          "url" => "http://tw.yahoo.com",
          "text" => "Yahoo"
        ]
      ]
    );
    return render();
  }
  function category() {
    $this->category = array(
      array("id" => 134512, "name" => "Mamie Daniel", "quantity" => 5),
      array("id" => 683432, "name" => "Brewer Perez", "quantity" => 0),
      array("id" => 923741, "name" => "Grant Reid", "quantity" => 9),
      array("id" => 965728, "name" => "Russell Salazar", "quantity" => 4),
      array("id" => 456891, "name" => "Melody Sosa", "quantity" => 16)
    );
    return render();
  }
}
?>