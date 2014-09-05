<?php
// helper methods and classes can be written here and included anywhere using include_helper() method .. pass helper file name as a string or a set of filenames as an array
// include_helper("application"); OR include_helper(array("application","application1"));

function breadcrumb($title = ""){
 $data = array(
    "collections" => "石材系列",
    "casestudy" => "成功案例",
    "blog" => "部落格",
    "aboutus" => "關於良錡",
    "contact" => "聯絡我們"
  );
	$html = "<ol class='breadcrumb'><li><a href='/''>首頁</a></li>";
  switch (Request::$Action) {
    case 'index':
      $html.="<li class='active'>".$data[Request::$Controller]."</li>";
      break;
    case "show":
      $url = Routes::url_helper(Request::$Controller,"index");
      $html.="<li><a href='{$url[0]}'>".$data[Request::$Controller]."</a></li>";
      $html.="<li class='active'>{$title}</li>";
      break;
    default:
      break;
  }
  $html.="</ol>";
  return $html;
}

?>