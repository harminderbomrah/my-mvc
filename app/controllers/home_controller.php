<?php
/*
	* Controller must extend ApplicationController
	* Controller must have index action
	* by using return render() inside an action will by default render action view in the controller folder inside app/views/
	  view and layout can be passed inside the render function like return render(array("view"=>"other_view","layout"=>false || "other_layout"));
	* the variables need to be passed to the view from the action must be defined using $this for example $this->name = "XYZ"; This can be used in view like $name;
	* return renderError('404'); can be used to generate 404 not found. 
	* return renderJson(); can be used to output the request with json. An array of data which needs to be converted should be passed alont with this method. Eg:  return renderJson($data);
	* return renderFile(<File Object>) will prompt the user to download the file;
	* params can be accessed using $this->params['get|post|<url declared variable>']
	* public $controller_layout = "home" will set the layout for whole controller.
	* public $before_filter = ['<method name>']; in array form, declare all the methods which have to be executed before the actual action.
	* public $after_filter = ['<method name>']; in array form, declare all the methods which have to be executed after the actual action.
	* FileManager::get_uploaded_files() will give all the uploaded files array. Developer can use foreach to iterate through all the files and use <instance>->save(<dir_name>); This directory will be made under files folder and saved with the name.
	* In order to change the name of the uploaded file, one can use <instance_name>->name = "harry.txt", this will set the file name to harry.txt
	* To create new file one can use new File(<Filename>); use <instance>->write(<String>) to write string and read() method to read from the file; 
	* <File Instance>->destory() will destroy the file. 
	* <File Instance>->rename(<filename>,<overwirte>true|false); will rename the file to the given name;
	* <File Instance>->to_absolute_url() will give the absolute path of the file instance;
	* Use <File Instance>->save(<directory>,<overwrite>true|false) method to save it to some directory under files folder. 
	* Pass File instance to img_tag to render file directly or use renderFile(<FileInstance>) to download the file;
	* Temporary files will be deleted which includes FileManager::get_uploaded_files(); and also if u create a new file using new File(<filename>); 
*/
class HomeController extends ApplicationController{
	var $controller_layout = "home";
	function index(){
		return render();
	}
	function portfolio_list(){
		return render();
	}
	function portfolio_item(){
		return render();
	}
	function blog_list(){
		return render();
	}
	function blog_item(){
		return render();
	}
}
?>
