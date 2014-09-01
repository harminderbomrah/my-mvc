<?php
  class ContactController extends ApplicationController{
    var $controller_layout = "home";

    function index(){

      $data = array(
        array(
          "title" => "Iaculis at erat pellentesque adipiscing commodo elit.",
          "id" => 10
        ),
        array(
          "title" => "At tempor commodo ullamcorper a lacus vestibulum sed arcu.",
          "id" => 11
        ),
        array(
          "title" => "Venenatis a condimentum vitae sapien pellentesque habitant morbi tristique senectus.",
          "id" => 12
        ),
        array(
          "title" => "Laoreet non curabitur gravida arcu.",
          "id" => 13
        ),
        array(
          "title" => "Sed libero enim sed faucibus turpis in eu mi bibendum.",
          "id" => 16
        ),
        array(
          "title" => "Amet volutpat consequat mauris nunc congue nisi.",
          "id" => 23
        ),
      );

      $this->askList = $data;
      return render();
    }
    function send() {
      $this->message = $this->params["message"];
      $this->email = $this->params["email"];
      $this->guest = $this->params["guest"];
      $mailer = new Mailer();
      $mailer->setMsgFromMailer("contact_us_mailer");
      $mailer->AddAddress(MAIL_USERNAME,MAIL_NAME);
      $mailer->Subject = "A new contact us mail.";
      $mailer->Send();
      return renderJson(array("success" => true));
    }
  }
?>