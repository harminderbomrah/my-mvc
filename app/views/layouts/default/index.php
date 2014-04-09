<!-- 
	* js_tag(), css_tag(), scss_tag() and img_tag() can be used to  render script , css , css , img tags respectively... can pass urls or name of asset inside assets folder
	* $yield should be placed where the view has to be rendered
-->

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?= $_site_title ?></title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<?= css_tag("http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial") ?>
		<?= css_tag("font-awesome.css") ?>
	</head>
	<body>
		<?= $yield ?>
	</body>
</html>
