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
		$user->add_relation("<model name>",id|object)
		$user->delete_relation("<model name>",id|object)

	* use $this->mount_uploaders(array("<column name>"=>"<uploader name>"));

*/


class Users extends ModelAdapter{
    function __construct($values=array()){
    	$this->mount_uploaders(array("image"=>"user_avatar"));
        parent::__construct($this,$values);
    }
}
?>