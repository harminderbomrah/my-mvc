<?= content_css_tag("nyfm/unit/file-manage.scss") ?>
<?php
  if($type) {
    echo render_partial("modal/filemanage/tinymce-filemanage");
  } else {
    echo render_partial("modal/filemanage/default-filemanage");
  }
?>
<?= js_tag("plugin/masonry/jquery-bridget/jquery.bridget.js") ?>
<?= js_tag("plugin/masonry/get-style-property/get-style-property.js") ?>
<?= js_tag("plugin/masonry/get-size/get-size.js") ?>
<?= js_tag("plugin/masonry/eventEmitter/EventEmitter.js") ?>
<?= js_tag("plugin/masonry/eventie/eventie.js") ?>
<?= js_tag("plugin/masonry/doc-ready/doc-ready.js") ?>
<?= js_tag("plugin/masonry/matches-selector/matches-selector.js") ?>
<?= js_tag("plugin/masonry/outlayer/item.js") ?>
<?= js_tag("plugin/masonry/outlayer/outlayer.js") ?>
<?= js_tag("plugin/masonry/masonry/masonry.js") ?>
<?= js_tag("plugin/masonry/imagesloaded/imagesloaded.js") ?>
<script>
  $('.modal-content').removeAttr('data-ng-init');
</script>