<?= content_css_tag("frontsite/unit/slide.scss") ?>
<div id="slide">
  <ul class="slide-list">
    <?php foreach ($slides as $key => $slide) { ?>
      <li class="slide-item">
        <div class="slide-title-content">
          <p class="slide-title"><?= $slide->title ?></p>
          <p class="slide-content"><?= $slide->content ?></p>
        </div>
        <div class="slide-image left-image" title="<?= $slide->title ?>" style="background-image: url('<?= Assets::find($slide->leftImage)->file['original']->to_absolute_url() ?>');"></div>
        <div class="slide-image right-image" title="<?= $slide->title ?>" style="background-image: url('<?= Assets::find($slide->rightImage)->file['original']->to_absolute_url() ?>');"></div>
      </li>
    <?php } ?>
  </ul>
</div>
