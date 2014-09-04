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
      $mailer = new Mailer();
      $mailer->setMsgFromMailer("contact_us_mailer");
      $mailer->AddAddress(MAIL_USERNAME,MAIL_NAME);
      $mailer->Subject = "A new contact us mail.";
      $mailer->Send();
      return renderJson(array("success" => true));
    }
  }
?>