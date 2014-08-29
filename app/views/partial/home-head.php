<head>
  <meta name="wot-verification" content="82a62872c36a134df0c4"/>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="<?= Site::first()->description." ".(Request::$Action == "show" ? $social_share_description : "") ?>">

  <meta property="og:type" content="website"/>
  <meta property="og:site_name" content="LC Stone"/>
  <meta property="og:title" content="<?= (Request::$Action == "show" ? $breadcrumb_title."-" : "") ?><?= Site::first()->title ?>"/>
  <meta property="og:description" content="<?= (Request::$Action == "show" ? $social_share_description : "") ?>"/>
  <meta property="og:url" content="<?= Request::current_url() ?>"/>
  <meta property="og:image" content="<?= (Request::$Action == "show" ? Request::server_name_with_port().$social_share_image : "") ?>"/>

  <title><?= (Request::$Action == "show" ? $breadcrumb_title."-" : "") ?><?= Site::first()->title ?></title>
  <?= css_tag("//cdn.jsdelivr.net/fontawesome/4.1.0/css/font-awesome.min.css") ?>
  <?= css_tag("frontsite/global.scss") ?>
  <?= render_page_specific_css() ?>
  <?= js_tag("lib/jquery/jquery-1.11.0.min.js") ?>
  <?= js_tag("lib/jquery/jquery.easing.1.3.js") ?>
  <?= js_tag("plugin/perfect-scrollbar/jquery.mousewheel.js") ?>
  <?= js_tag("plugin/perfect-scrollbar/perfect-scrollbar.js") ?>
  <?= js_tag("plugin/window-resize/window-resize.js") ?>
  <?= js_tag("plugin/fastclick/lib/fastclick.js") ?>
  <?= js_tag("plugin/loremjs/lorem.js") ?>
  <?= js_tag("frontsite/main-menu.js") ?>
  <?= js_tag("frontsite/main.js") ?>
  <!--[if lt IE 9]>
    <?= js_tag("plugin/html5shiv/src/html5shiv.js") ?>
  <![endif]-->
</head>
