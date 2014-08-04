<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="<?= Site::first()->description ?>">

  <meta property="og:type" content="website"/>
  <meta property="og:site_name" content="LC Stone"/>
  <meta property="og:title" content="<?= Site::first()->title ?>"/>
  <meta property="og:description" content="<?= Site::first()->description ?>"/>
  <meta property="og:url" content="http://nowyoufindme.no-ip.org:8888"/>
  <meta property="og:image" content="http://nowyoufindme.no-ip.org:8888/files/assets/8/original/l_stone08.jpg"/>
  <meta property="og:image" content="http://nowyoufindme.no-ip.org:8888/files/assets/3/large/l_stone03.jpg"/>

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
