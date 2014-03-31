<?php
/*
	* Controller must extend ApplicationController
	* Controller must have index action
	* by using return render() inside an action will by default render action view in the controller folder inside app/views/
	  view and layout can be passed inside the render function like return render(array("view"=>"other_view","layout"=>false || "other_layout"));
	* the variables need to be passed to the view from the action must be defined using $this for example $this->name = "XYZ"; This can be used in view like $name;
	* return renderError('404'); can be used to generate 404 not found. 
	* return renderJson(); can be used to output the request with json. An array of data which needs to be converted should be passed alont with this method. Eg:  return renderJson($data);
	* params can be accessed using $this->params['get|post|<url declared variable>']
*/
class HomeController extends ApplicationController{
	// public $controller_layout = "home";
	function index(){
		$this->loggedin = $this->current_user->loggedin;
		if($this->current_user->loggedin){
			$this->name = $this->current_user->name;
		}
		return render();
	}
}
?>
