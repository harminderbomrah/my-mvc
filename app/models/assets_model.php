<?php
class Assets extends ModelAdapter{
    function __construct($values=array()){
      $this->mount_uploaders(array("file"=>"asset"));
      parent::__construct($this,$values);
    }
}
?>
