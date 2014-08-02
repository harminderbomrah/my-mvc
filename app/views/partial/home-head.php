<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="<?= Site::first()->description ?>">
  <title><?= Site::first()->title ?></title>
  <?= css_tag("//cdn.jsdelivr.net/fontawesome/4.1.0/css/font-awesome.min.css") ?>
  <?= css_tag("frontsite/global.scss") ?>
  <?= render_page_specific_css() ?>
  <?= js_tag("lib/jquery/jquery-1.11.0.min.js") ?>
  <?= js_tag("lib/jquery/jquery.easing.1.3.js") ?>
  <?= js_tag("plugin/perfect-scrollbar/jquery.mousewheel.js") ?>
  <?= js_tag("plugin/perfect-scrollbar/perfect-scrollbar.js") ?>
  <?= js_tag("plugin/window-resize/window-resize.js") ?>
  <?= js_tag("plugin/loremjs/lorem.js") ?>
  <?= js_tag("frontsite/main-menu.js") ?>
  <?= js_tag("frontsite/main.js") ?>
</head>
