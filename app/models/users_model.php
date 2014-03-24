<?php
class Users extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values=array());
    }

    function look_for_coin($name){
    	return $this->query("SELECT id FROM $this->table WHERE primary_currency_name = '{$name}'");
    }
}
?>