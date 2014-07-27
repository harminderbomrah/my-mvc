<?= content_css_tag("default.css") ?>
<style type="text/css">
  .slide-image{
    display: inline-block;
    margin: 0;
    height: 600px;
    width: 500px;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
  }
</style>
<ul>
  <?php foreach ($slides as $key => $slide) { ?>
    <li>
      <div class="title-slide">
        <p class="slide-title"><?= $slide->title ?></p>
        <p class="slide-content"><?= $slide->content ?></p>
      </div>
      <div class="slide-image left-image" style="background-image: url('<?= Assets::find($slide->leftImage)->file['original']->to_absolute_url() ?>');"></div><div class="slide-image right-image" style="background-image: url('<?= Assets::find($slide->rightImage)->file['original']->to_absolute_url() ?>');"></div>
    </li>
  <?php } ?>
</ul>
<div id="slide"></div>
