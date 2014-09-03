<?php
  class Slide extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values);
    }

    function can_publish(){
      if($this->disabled || $this->trash){
        return false;
      }
      if($this->publishDate == "0000-00-00 00:00:00"){
        return true;
      }
      $pdate = DateTime::createFromFormat("Y-m-d",strftime("%Y-%m-%d",strtotime($this->publishDate)));
      $edate = DateTime::createFromFormat("Y-m-d",strftime("%Y-%m-%d",strtotime($this->endDate)));
      $date = new DateTime();
      if($pdate <= $date && $edate >= $date){
        return true;
      }else{
        return false;
      }
    }
  }
?>