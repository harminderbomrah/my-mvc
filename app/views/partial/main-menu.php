<?php
  $tags = Tags::all_with_quantity();
  $tags_limit = 8;
?>
<header id="navigation">
  <div class="nav-bar">
    <div class="nav-collapse"><i class="fa fa-fw fa-navicon"></i></div>
    <p class="small-logo"><a href="/"><?= img_tag("frontend/nav-logo-s.png", array(titile=>"良錡石材 商標", alt=>"良錡石材 商標")) ?></a></p>
    <ul class="nav-bar-menu list-unstyled">
      <li class="nav-bar-item have-sub collections"><a href="#collections"><i class="icon fa fa-apple"></i></a></li>
      <li class="nav-bar-item have-sub case-study"><a href="#case-study"><i class="icon fa fa-apple"></i></a></li>
      <li class="nav-bar-item have-sub blog"><a href="#blog"><i class="icon fa fa-apple"></i></a></li>
      <li class="nav-bar-item about-us"><a href="/about-us"><i class="icon fa fa-apple"></i></a></li>
      <li class="nav-bar-item contact"><a href="/contact"><i class="icon fa fa-apple"></i></a></li>
      <li class="nav-bar-item search"><p class="search-trigger"><i class="icon fa fa-apple"></i></p></li>
    </ul>
  </div>
  <div class="nav-body">
    <h1 class="site-name" title="良錡石材">
      <a href="/">
        <span class="hide">良錡石材</span>
        <?= img_tag("frontend/nav-logo.png", array(titile=>"良錡石材 商標", alt=>"良錡石材 商標")) ?>
      </a>
    </h1>
    <nav role="navigation">
      <h2 class="hide">網站主選單</h2>
      <ul class="mune-list list-unstyled">
        <li class="mune-item have-sub collections">
          <p class="mune-title"><a href="#collections"><span class="en">Collections</span><span class="zh">石 材 系 列</span></a></p>
        </li>
        <li class="mune-item have-sub case-study">
          <p class="mune-title"><a href="#case-study"><span class="en">Case Study</span><span class="zh">成 功 案 例</span></a></p>
        </li>
        <li class="mune-item have-sub blog">
          <p class="mune-title"><a href="#blog"><span class="en">Blog</span><span class="zh">部 落 格</span></a></p>
        </li>
        <li class="mune-item about-us">
          <p class="mune-title"><a href="/about-us"><span class="en">About US</span><span class="zh">關 於 良 錡</span></a></p>
        </li>
        <li class="mune-item contact">
          <p class="mune-title"><a href="/contact"><span class="en">Contact</span><span class="zh">聯 絡 我 們</span></a></p>
        </li>
        <li class="mune-item search">
          <!-- <input type="checkbox" id="search" class="hide"> -->
          <p class="mune-title"><span class="search-trigger"><span class="en">Search</span><span class="zh">搜 尋</span></span></p>
          <p class="overlay search-trigger"></p>
          <form class="search-box">
            <input type="text" name="search" placeholder="您可搜尋新聞、產品、anything...">
            <button tyoe="submit">SEARCH</button>
          </form>
        </li>
      </ul>
    </nav>
    <nav class="social" role="social media menu">
      <h2 class="hide">社交平台選單</h2>
      <ul class="social-mune list-unstyled">
        <li><a href="https://www.facebook.com/pages/良錡石材-水晶時代各種石材設計與裝潢介紹/107145262639568" target="_blink"><i class="fa fa-facebook"></i></a></li>
        <li><a href="#" target="_blink"><i class="fa fa-google-plus"></i></a></li>
        <li><a href="/contact"><i class="fa fa-envelope-o"></i></a></li>
      </ul>
    </nav>
  </div>
  <div class="nav-sub">
    <div id="collections" class="nav-sub-item">
      <span class="mune-sub-close" href="#"><i class="fa fa-fw fa-times"></i></span>
      <h3 class="mune-sub-title"><span class="hide">石材系列</span>Collections</h3>
      <div class="nav-sub-scroll-zone">
        <div class="nav-sub-item-inner">
          <div class="tag-list">
            <ul class="list-inline">
              <?php foreach ($tags as $key => $tag) { ?>
                <li class="tag-item"><a href="/collections?tag=<?= $tag["id"] ?>"><?= $tag["name"] ?></a></li>
              <?php } ?>
              <?php if($key>$tags_limit){ ?>
                <li class="more"><span>更多標籤</span><i class="fa fa-fw fa-angle-right"></i></li>
              <?php } ?>
            </ul>
          </div>
          <ul class="mune-sub list-unstyled">
            <?php $categories = Category::all_with_quantity('product'); foreach ($categories as $category) { ?>
              <li class="mune-sub-item">
                <a href="/collections?category=<?= $category['id'] ?>">
                  <?= $category['name'] ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div id="case-study" class="nav-sub-item">
      <span class="mune-sub-close" href="#"><i class="fa fa-fw fa-times"></i></span>
      <h3 class="mune-sub-title"><span class="hide">成功案例</span>Case Study</h3>
      <div class="nav-sub-scroll-zone">
        <div class="nav-sub-item-inner">
          <div class="tag-list">
            <ul class="list-inline">
              <?php foreach ($tags as $key => $tag) { ?>
                <li class="tag-item"><a href="/case_study?tag=<?= $tag["id"] ?>"><?= $tag["name"] ?></a></li>
              <?php } ?>
              <?php if($key>$tags_limit){ ?>
                <li class="more"><span>更多標籤</span><i class="fa fa-fw fa-angle-right"></i></li>
              <?php } ?>
            </ul>
          </div>
          <ul class="mune-sub list-unstyled">
            <?php $categories = Category::all_with_quantity('case'); foreach ($categories as $category) { ?>
              <li class="mune-sub-item">
                <a href="/case-study?category=<?= $category['id'] ?>">
                  <?= $category['name'] ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div id="blog" class="nav-sub-item">
      <span class="mune-sub-close" href="#"><i class="fa fa-fw fa-times"></i></span>
      <h3 class="mune-sub-title"><span class="hide">部落格</span>Blog</h3>
      <div class="nav-sub-scroll-zone">
        <div class="nav-sub-item-inner">
          <div class="tag-list">
            <ul class="list-inline">
              <?php foreach ($tags as $key => $tag) { ?>
                <li class="tag-item"><a href="/blog?tag=<?= $tag["id"] ?>"><?= $tag["name"] ?></a></li>
              <?php } ?>
              <?php if($key>$tags_limit){ ?>
                <li class="more"><span>更多標籤</span><i class="fa fa-fw fa-angle-right"></i></li>
              <?php } ?>
            </ul>
          </div>
          <ul class="mune-sub list-unstyled">
            <?php $categories = Category::all_with_quantity('article'); foreach ($categories as $category) { ?>
              <li class="mune-sub-item">
                <a href="/blog?category=<?= $category['id'] ?>">
                  <?= $category['name'] ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="overlay mune-sub-close"></div>
  </div>
</header>