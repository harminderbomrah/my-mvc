<?php
  class ContactController extends ApplicationController{
    var $controller_layout = "home";

    function index(){
      return render();
    }
    function send() {
      $this->message = $this->params["message"];
      $this->email = $this->params["email"];
      $this->company = $this->params["company"];
      $this->guest = $this->params["guest"];
      $productlist = $this->params["product"];
      $products = array();
      foreach ($productlist as $product) {
        $product = Products::find($product["id"]);
        if($product){
          array_push($products, array(
              "id" => $product->id,
              "title"  => $product->title,
              "image" => ($product->assets_relation_ids[0] ? Assets::find($product->assets_relation_ids[0])->file["thumb"]->to_absolute_url() : "")
          ));
        }
      }
      $this->products = $products;
      $mailer = new Mailer();
      $mailer->setMsgFromMailer("contact_us_mailer");
      $mailer->AddAddress(MAIL_USERNAME,MAIL_NAME);
      $mailer->Subject = (count($products) > 0 ? "產品詢問" : "訪客來信");
      $mailer->Send();
      return renderJson(array("success" => true));
    }
  }
?>