<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      if($type) {
        echo js_tag("lib/jquery/jquery-1.11.0.min.js");
        echo js_tag("lib/jquery/jquery.easing.1.3.js");
        echo js_tag("lib/angular/angular.min.js");
      }
    ?>
    <?= render_page_specific_css() ?>
  </head>
	<body <?php if($type) { echo 'data-ng-app="'.$type.'"';} ?>>
		<?= $yield ?>
	</body>
</html>
