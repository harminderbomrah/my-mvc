<?= content_css_tag("frontsite/unit/slide.scss") ?>
<?= content_css_tag("frontsite/unit/promos.scss") ?>
<div id="slide">
  <ul class="slide-list">
    <?php foreach ($slides as $key => $slide) { ?>
      <?php if($slide->can_publish()){ ?>
        <li class="slide-item">
          <div class="slide-series" style="background-image: url('/app/assets/images/frontend/series-img-<?= $slide->series ?>.png');"></div>
          <div class="slide-image left-image" title="<?= $slide->title ?>" style="background-image: url('<?= Assets::find($slide->leftImage)->file['original']->to_absolute_url() ?>');"></div>
          <div class="slide-image right-image" title="<?= $slide->title ?>" style="background-image: url('<?= Assets::find($slide->rightImage)->file['original']->to_absolute_url() ?>');"></div>
        </li>
      <?php } ?>
    <?php } ?>
  </ul>
</div>
<div id="promos" class="row">
  <section class="promos-item col-4 col-md-12 blog">
    <div class="promos-pagination">
      <span class="promos-pagination-title">blog</span>
      <span class="promos-pagination-number">1</span>
      <span class="promos-pagination-number">2</span>
      <span class="promos-pagination-number">3</span>
    </div>
    <ul class="promos-post">
      <?php foreach ($articles as $key => $article) { ?>
        <li class="promos-post-item" style="background-image: url('<?= $article['img'] ?>');">
          <p class="promos-post-info">
            <span class="promos-post-category"><?= $article['category'] ?></span>
            <span class="promos-post-date"><?= $article['date'] ?></span>
          </p>
          <h1 class="promos-post-title">
            <a href="/blog/<?= $article['id'] ?>"><?= $article['title'] ?></a>
          </h1>
        </li>
      <?php } ?>
    </ul>
  </section>
  <section class="promos-item col-4 col-md-12 collections">
    <div class="promos-pagination">
      <span class="promos-pagination-title">collections</span>
      <span class="promos-pagination-number">1</span>
      <span class="promos-pagination-number">2</span>
      <span class="promos-pagination-number">3</span>
    </div>
    <ul class="promos-post">
      <?php foreach ($products as $key => $product) { ?>
        <li class="promos-post-item" style="background-image: url('<?= $product['img'] ?>');">
          <p class="promos-post-info">
            <span class="promos-post-category"><?= $product['category'] ?></span>
            <span class="promos-post-date"><?= $product['date'] ?></span>
          </p>
          <h1 class="promos-post-title">
            <a href="/collections/<?= $product['id'] ?>"><?= $product['title'] ?></a>
          </h1>
        </li>
      <?php } ?>
    </ul>
  </section>
  <section class="promos-item col-4 col-md-12 case-study">
    <div class="promos-pagination">
      <span class="promos-pagination-title">case study</span>
      <span class="promos-pagination-number">1</span>
      <span class="promos-pagination-number">2</span>
      <span class="promos-pagination-number">3</span>
    </div>
    <ul class="promos-post">
      <?php foreach ($cases as $key => $case) { ?>
        <li class="promos-post-item" style="background-image: url('<?= $case['img'] ?>');">
          <p class="promos-post-info">
            <span class="promos-post-category"><?= $case['category'] ?></span>
            <span class="promos-post-date"><?= $case['date'] ?></span>
          </p>
          <h1 class="promos-post-title">
            <a href="/case_study/<?= $case['id'] ?>"><?= $case['title'] ?></a>
          </h1>
        </li>
      <?php } ?>
    </ul>
  </section>
</div>
<?= js_tag("frontsite/slide.js") ?>
<?= js_tag("frontsite/promos.js") ?>