<?= content_css_tag("frontsite/unit/list.scss") ?>
<?= render_partial("partial/top-nav") ?>
<?php if($_COOKIE['listView'] == 'block' || $_COOKIE['listView'] != true) {?>
  <?= render_partial("blog/block") ?>
<?php } else { ?>
  <?= render_partial("blog/list") ?>
<?php } ?>
<?= render_partial("partial/pagination") ?>