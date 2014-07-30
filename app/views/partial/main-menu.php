<header class="navigation">
  <div class="navigation-inner">
    <h1 class="site-name" title="良錡石材">
      <a href="/">
        <span class="hide">良錡石材</span>
        <?= img_tag("frontend/nav-logo.png", array(titile=>"良錡石材 商標", alt=>"良錡石材 商標")) ?>
      </a>
    </h1>
    <nav role="navigation">
      <h2 class="hide">網站主選單</h2>
      <ul class="mune-group list-unstyled">
        <li class="mune-item have-sub">
          <p class="mune-title"><a href="#cllections"><i class="icon"></i><span class="en">Cllections</span><span class="zh">石 材 系 列</span></a></p>
        </li>
        <li class="mune-item have-sub">
          <p class="mune-title"><a href="#case-study"><i class="icon"></i><span class="en">Case Study</span><span class="zh">成 功 案 例</span></a></p>
        </li>
        <li class="mune-item have-sub">
          <p class="mune-title"><a href="#blog"><i class="icon"></i><span class="en">Blog</span><span class="zh">部 落 格</span></a></p>
        </li>
        <li class="mune-item">
          <p class="mune-title"><a href="/about_us"><i class="icon"></i><span class="en">About US</span><span class="zh">關 於 良 錡</span></a></p>
        </li>
        <li class="mune-item">
          <p class="mune-title"><a href="/contact"><i class="icon"></i><span class="en">Contact</span><span class="zh">聯 絡 我 們</span></a></p>
        </li>
        <li class="mune-item search">
          <input type="checkbox" id="search" class="hide">
          <p class="mune-title"><label for="search"><i class="icon"></i><span class="en">Search</span><span class="zh">搜 尋</span></label></p>
          <label class="overlay" for="search"></label>
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
        <li><a href="https://www.facebook.com/pages/良錡石材-水晶時代各種石材設計與裝潢介紹/107145262639568"><i class="icon icon-fb"></i>facebook</a></li>
        <li><a href="#"><i class="icon icon-google-plus"></i>google+</a></li>
        <li><a href="#"><i class="icon icon-mail"></i>mail</a></li>
      </ul>
    </nav>
  </div>
  <div class="mune-sub-group">
    <div id="cllections" class="mune-sub-group-item">
      <span class="mune-sub-close" href="#"><i class="fa fa-fw fa-times"></i></span>
      <h3 class="mune-sub-title"><span class="hide">石材系列</span>Cllections</h3>
      <div class="mune-sub-group-scroll-zone">
        <div class="mune-sub-group-item-inner">
          <div class="tag-list">
            <ul class="list-inline">
              <li class="tag-item"><a href="">華麗</a></li>
              <li class="tag-item"><a href="">極簡</a></li>
              <li class="tag-item"><a href="">新品</a></li>
              <li class="tag-item"><a href="">特價優惠</a></li>
              <li class="tag-item"><a href="">深色</a></li>
              <li class="tag-item"><a href="">特價優惠</a></li>
              <li class="tag-item"><a href="">淺色</a></li>
              <li class="more"><span>更多標籤</span><i class="fa fa-fw fa-angle-right"></i></li>
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
    <div id="case-study" class="mune-sub-group-item">
      <span class="mune-sub-close" href="#"><i class="fa fa-fw fa-times"></i></span>
      <h3 class="mune-sub-title"><span class="hide">成功案例</span>Case Study</h3>
      <div class="mune-sub-group-scroll-zone">
        <div class="mune-sub-group-item-inner">
          <div class="tag-list">
            <ul class="list-inline">
              <li class="tag-item"><a href="">華麗</a></li>
              <li class="tag-item"><a href="">極簡</a></li>
              <li class="tag-item"><a href="">新品</a></li>
              <li class="tag-item"><a href="">特價優惠</a></li>
              <li class="tag-item"><a href="">深色</a></li>
              <li class="tag-item"><a href="">特價優惠</a></li>
              <li class="tag-item"><a href="">淺色</a></li>
              <li class="tag-item"><a href="">花紋</a></li>
              <li class="tag-item"><a href="">新品</a></li>
              <li class="more"><span>更多標籤</span><i class="fa fa-fw fa-angle-right"></i></li>
            </ul>
          </div>
          <ul class="mune-sub list-unstyled">
            <?php $categories = Category::all_with_quantity('case'); foreach ($categories as $category) { ?>
              <li class="mune-sub-item">
                <a href="/case_study?category=<?= $category['id'] ?>">
                  <?= $category['name'] ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div id="blog" class="mune-sub-group-item">
      <span class="mune-sub-close" href="#"><i class="fa fa-fw fa-times"></i></span>
      <h3 class="mune-sub-title"><span class="hide">部落格</span>Blog</h3>
      <div class="mune-sub-group-scroll-zone">
        <div class="mune-sub-group-item-inner">
          <div class="tag-list">
            <ul class="list-inline">
              <li class="tag-item"><a href="">華麗</a></li>
              <li class="tag-item"><a href="">極簡</a></li>
              <li class="tag-item"><a href="">新品</a></li>
              <li class="tag-item"><a href="">特價優惠</a></li>
              <li class="tag-item"><a href="">深色</a></li>
              <li class="tag-item"><a href="">特價優惠</a></li>
              <li class="tag-item"><a href="">淺色</a></li>
              <li class="tag-item"><a href="">花紋</a></li>
              <li class="tag-item"><a href="">新品</a></li>
              <li class="more"><span>更多標籤</span><i class="fa fa-fw fa-angle-right"></i></li>
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