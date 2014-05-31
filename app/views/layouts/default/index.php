<!--
	* js_tag(), css_tag(), scss_tag() and img_tag() can be used to  render script , css , css , img tags respectively... can pass urls or name of asset inside assets folder
	* $yield should be placed where the view has to be rendered
	* render_page_specific_css() renders all page specific css from content tag;
-->
<!DOCTYPE html>
<html lang="en">
  <?= render_partial("partial/login-head") ?>
	<body>
		<?= $yield ?>
	</body>
</html>
