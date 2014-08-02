<?= content_css_tag("frontsite/unit/slide.scss") ?>
<?= content_css_tag("frontsite/unit/promos.scss") ?>
<div id="slide">
  <ul class="slide-list">
    <?php foreach ($slides as $key => $slide) { ?>
      <li class="slide-item">
        <!-- <div class="slide-series" style="background-image: url('frontend/series-img-<?#= $slide->series ?>.png');"></div> -->
        <div class="slide-series" style="background-image: url('/app/assets/images/frontend/series-img-modern.png');"></div>
        <div class="slide-image left-image" title="<?= $slide->title ?>" style="background-image: url('<?= Assets::find($slide->leftImage)->file['original']->to_absolute_url() ?>');"></div>
        <div class="slide-image right-image" title="<?= $slide->title ?>" style="background-image: url('<?= Assets::find($slide->rightImage)->file['original']->to_absolute_url() ?>');"></div>
      </li>
    <?php } ?>
  </ul>
</div>
<div id="promos">
  <section class="promos-item blog">
    <div class="promos-pagination">
      <span class="promos-pagination-title">blog</span>
      <span class="promos-pagination-number">1</span>
      <span class="promos-pagination-number">2</span>
      <span class="promos-pagination-number">3</span>
    </div>
    <ul class="promos-post">
      <li class="promos-post-item" style="background-image: url('http://ppcdn.500px.org/78347591/e181b568ce021af134ffd84e50ab13b3ecab5657/600.jpg');">
        <p class="promos-post-info">
          <span class="promos-post-category" data-lorem="1w"></span>
          <span class="promos-post-date">Apr 1, 2014</span>
        </p>
        <h1 class="promos-post-title">
          <a href="#" data-lorem="1s"></a>
        </h1>
      </li>
      <li class="promos-post-item" style="background-image: url('http://ppcdn.500px.org/78316829/4c4a60673a072ca00f800e253e1e29b706768506/2048.jpg');">
        <p class="promos-post-info">
          <span class="promos-post-category" data-lorem="1w"></span>
          <span class="promos-post-date">Apr 1, 2014</span>
        </p>
        <h1 class="promos-post-title">
          <a href="#" data-lorem="1s"></a>
        </h1>
      </li>
      <li class="promos-post-item" style="background-image: url('http://ppcdn.500px.org/78278523/d1b7b03d20b930c3022172b0c6ffbe4a5a56798d/2048.jpg');">
        <p class="promos-post-info">
          <span class="promos-post-category" data-lorem="1w"></span>
          <span class="promos-post-date">Apr 1, 2014</span>
        </p>
        <h1 class="promos-post-title">
          <a href="#" data-lorem="1s"></a>
        </h1>
      </li>
    </ul>
  </section>
  <section class="promos-item cllections">
    <div class="promos-pagination">
      <span class="promos-pagination-title">cllections</span>
      <span class="promos-pagination-number">1</span>
      <span class="promos-pagination-number">2</span>
      <span class="promos-pagination-number">3</span>
    </div>
    <ul class="promos-post">
      <li class="promos-post-item" style="background-image: url('http://ppcdn.500px.org/78256769/891ea3ec5a63e4fa38d123011bd0a6d5cdfa5a77/2048.jpg');">
        <p class="promos-post-info">
          <span class="promos-post-category" data-lorem="1w"></span>
          <span class="promos-post-date">Apr 1, 2014</span>
        </p>
        <h1 class="promos-post-title">
          <a href="#" data-lorem="1s"></a>
        </h1>
      </li>
      <li class="promos-post-item" style="background-image: url('http://ppcdn.500px.org/78272133/fd3292ffc8be7070b2f42d790eae80d16ee2e27c/2048.jpg');">
        <p class="promos-post-info">
          <span class="promos-post-category" data-lorem="1w"></span>
          <span class="promos-post-date">Apr 1, 2014</span>
        </p>
        <h1 class="promos-post-title">
          <a href="#" data-lorem="1s"></a>
        </h1>
      </li>
      <li class="promos-post-item" style="background-image: url('http://ppcdn.500px.org/78342513/2e236542aee295f9e240c74b5dcc922993f2d964/2048.jpg');">
        <p class="promos-post-info">
          <span class="promos-post-category" data-lorem="1w"></span>
          <span class="promos-post-date">Apr 1, 2014</span>
        </p>
        <h1 class="promos-post-title">
          <a href="#" data-lorem="1s"></a>
        </h1>
      </li>
    </ul>
  </section>
  <section class="promos-item case-study">
    <div class="promos-pagination">
      <span class="promos-pagination-title">case study</span>
      <span class="promos-pagination-number">1</span>
      <span class="promos-pagination-number">2</span>
      <span class="promos-pagination-number">3</span>
    </div>
    <ul class="promos-post">
      <li class="promos-post-item" style="background-image: url('http://ppcdn.500px.org/78343023/47a41b7b571f6f9498aebbaf83faaa249d5cbe71/2048.jpg');">
        <p class="promos-post-info">
          <span class="promos-post-category" data-lorem="1w"></span>
          <span class="promos-post-date">Apr 1, 2014</span>
        </p>
        <h1 class="promos-post-title">
          <a href="#" data-lorem="1s"></a>
        </h1>
      </li>
      <li class="promos-post-item" style="background-image: url('http://ppcdn.500px.org/78341527/fa810b97130b5463d68b9a604ba2b430645ccc1f/600.jpg');">
        <p class="promos-post-info">
          <span class="promos-post-category" data-lorem="1w"></span>
          <span class="promos-post-date">Apr 1, 2014</span>
        </p>
        <h1 class="promos-post-title">
          <a href="#" data-lorem="1s"></a>
        </h1>
      </li>
      <li class="promos-post-item" style="background-image: url('http://ppcdn.500px.org/78317703/cc1d3c31cae6dd7f55535e84feb455640a6629c1/2048.jpg');">
        <p class="promos-post-info">
          <span class="promos-post-category" data-lorem="1w"></span>
          <span class="promos-post-date">Apr 1, 2014</span>
        </p>
        <h1 class="promos-post-title">
          <a href="#" data-lorem="1s"></a>
        </h1>
      </li>
    </ul>
  </section>
</div>
<?= js_tag("frontsite/slide.js") ?>
<?= js_tag("frontsite/promos.js") ?>