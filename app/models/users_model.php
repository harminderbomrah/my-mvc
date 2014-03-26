<?php
/*
	* Model should extends ModelAdapter
	all the models must have this constructor function
	function __construct($values=array()){
        parent::__construct($this,$values=array());
    }
	* static functions which can be used
		User::find(<int>);
		User::find_by(<array>);
		User:all();

	* non-static functions which can be used
		$user = new User(<array>); can pass array with column names and values as key, value pair. 
		$user->name = "ZYX";
		$user->save();
		$user->delete();
		$user->update_values(<array>);
		$user->qyery(<query>);

*/


class Users extends ModelAdapter{
    function __construct($values=array()){
        parent::__construct($this,$values=array());
    }
}
?>