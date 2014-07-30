<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title><?= Site::first()->title ?></title>
  <?= css_tag("backsite/application.scss") ?>
  <?= render_page_specific_css() ?>

  <?= js_tag("lib/jquery/jquery-1.11.0.min.js") ?>
  <?= js_tag("lib/jquery/jquery.easing.1.3.js") ?>
  <?= js_tag("lib/angular/angular.min.js") ?>
  <?= js_tag("lib/angular/angular-animate.min.js") ?>
  <?= js_tag("lib/angular/angular-cookies.js") ?>

  <?= js_tag("app/backend/application.js") ?>
  <?= js_tag("app/backend/directives.js") ?>
  <?= js_tag("app/backend/filters.js") ?>
  <?= js_tag("app/backend/services.js") ?>
  <?= js_tag("app/backend/controllers/sidebar.js") ?>

  <?#= js_tag("plugin/bootstrap.min.js") ?>
  <?= js_tag("plugin/ngProgress/ngProgress.js") ?>
  <?= js_tag("plugin/toaster/jquery-toastr.js") ?>
  <?= js_tag("plugin/ui-bootstrap-tpls-0.11.0.js") ?>
  <?= js_tag("plugin/chosen/ng-chosen.js") ?>

  <?= js_tag("admin.js") ?>
</head>