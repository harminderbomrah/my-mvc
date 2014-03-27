<!-- 
	* render_partial() can be used to render the partials eg: render_partial("home/partial"); 
	* variables from the action in controller can directly be used here eg $this->name = "XYZ"; can be used here as $name;
	* js_tag(), css_tag(),  content_css_tag() and img_tag() can be used to  render script , css , css ,  img tags respectively... can pass urls or name of asset inside assets folder
-->

<h3>Welcome <?= $name ?> to My-MVC</h3>
<div>
	<p>Find me in app/views/home/</p>
	<?php if($loggedin) { ?>
		<h4><a href="user/logout">Logout</a></h4>
	<?php }?>
</div>