<?php
class ApplicationController extends MvcController{
  function authenticate_user(){
    $this->current_user->needs_authentication();
  }	
}

?>