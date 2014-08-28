<?php  $tags = Tags::all_with_quantity(); ?>
<section class="main-wrap mini-height border-bottom main-list list-casestudy row">
  <header class="top-post row">
    <?php foreach ($articles as $index => $article) { ?>
      <?php if($index < 2) {?>
        <div class="top-post-item col-6 col-md-12" <?php if($article['image']!=""){echo 'style="background-image: url('.$article['image']->to_absolute_url().')"';}?>>
          <div class="top-post-item-info">
            <p class="top-post-item-header">
              <?php if($_GET['category'] != true) { ?>
                <span class="top-post-item-category"><?php echo Category::find($article['category'])->name ?></span>
              <?php } ?>
              <span class="top-post-item-date"><?= strftime("%b %d, %Y",($article["publishDate"] / 1000)) ?></span>
            </p>
            <h3 class="top-post-item-name">
              <a class="top-post-item-link" href="/blog/<?= $article['id'] ?>">
                <?php echo $article['title'] ?>
              </a>
            </h3>
            <p class="top-post-item-content" data-lorem="5s"></p>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
  </header>
  <main class="content col-8 col-md-12">
    <?php if($_GET['category']){ ?>
    <div class="index-header">
      <h3 class="index-header-title content-title" title="<?= Category::find($_GET['category'])->name ?>"><?= Category::find($_GET['category'])->name ?></h3>
      <p class="index-header-description"><?= Category::find($_GET['category'])->description ?></p>
    </div>
    <?php } ?>
    <ui class="list-unstyled">
      <?php foreach ($articles as $article) { ?>
        <li class="list-item">
          <div class="list-item-image" <?php if($article['image']!=""){echo 'style="background-image: url('.$article['image']->to_absolute_url().')"';}?>></div>
          <section class="list-item-info">
            <p class="list-item-header">
              <!-- <span class="list-item-location">
                <i class="fa fa-map-marker"></i> KAOSHOUNG
              </span> -->
              <?php if($_GET['category'] != true) { ?>
                <span class="list-item-category"><?php echo Category::find($article['category'])->name ?></span>
              <?php } ?>
              <span class="list-item-date"><?= strftime("%b %d, %Y",($article["publishDate"] / 1000)) ?></span>
            </p>
            <h4 class="list-item-name">
              <a class="list-item-link" href="/blog/<?= $article['id'] ?>">
                <?php echo $article['title'] ?>
              </a>
            </h4>
            <p class="list-item-content"><?= strip_tags($article["content"]) ?></p>
          </section>
        </li>
      <?php } ?>
    </ui>
  </main>
  <aside class="aside col-4 col-md-12">
    <div class="sort tab-group">
      <ul class="tab-header list-inline">
        <li class="tab-header-item active" data-tab=".sort-category">類別篩選</li>
        <li class="tab-header-item" data-tab=".sort-tag">標籤分類</li>
      </ul>
      <div class="tab-body">
        <ul class="sort-category tab-body-item list-unstyled active in">
          <li class="<?php if($_GET['category'] != true) echo 'active'?>"><a href="/blog/">All</a></li>
          <?php foreach($categories as $categorie) { ?>
            <li class="<?php if($_GET['category'] == $categorie['id']) echo 'active'?>"><a href="/blog?category=<?= $categorie['id'] ?>"><?= $categorie['name'] ?></a></li>
          <?php } ?>
        </ul>
        <ul class="sort-tag tab-body-item list-inline">
         <?php foreach ($tags as $key => $tag) { ?>
            <li ><a href="/blog?tag=<?= $tag["id"] ?>"><?= $tag["name"] ?></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="post tab-group">
      <ul class="tab-header list-inline">
        <li class="tab-header-item active" data-tab=".post-hot">熱門文章</li>
        <li class="tab-header-item" data-tab=".post-top">推薦內容</li>
      </ul>
      <div class="tab-body">
        <ul class="post-hot tab-body-item list-unstyled active in">
          <?php foreach($articlesAll as $article) { ?>
            <?php if($article['hot']) {?>
              <li class="post-item">
                <div class="post-item-image" <?php if($article['image']!=""){echo 'style="background-image: url('.$article['image']->to_absolute_url().')"';}?>></div>
                <section class="post-item-info">
                  <p class="post-item-header">
                    <span class="post-item-category"><?php echo Category::find($article['category'])->name ?></span>
                    <span class="post-item-date"><?= strftime("%b %d, %Y",($article["publishDate"] / 1000)) ?></span>
                  </p>
                  <h3 class="post-item-name">
                    <a class="post-item-link" href="/blog/<?= $article['id'] ?>">
                      <?php echo $article['title'] ?>
                    </a>
                  </h3>
                </section>
              </li>
            <?php } ?>
          <?php } ?>
        </ul>
        <ul class="post-top tab-body-item list-unstyled">
          <?php foreach ($articlesAll as $index => $article) { ?>
            <?php if($article['top']) {?>
              <li class="post-item">
                <div class="post-item-image" <?php if($article['image']!=""){echo 'style="background-image: url('.$article['image']->to_absolute_url().')"';}?>></div>
                <section class="post-item-info">
                  <p class="post-item-header">
                    <span class="post-item-category"><?php echo Category::find($article['category'])->name ?></span>
                    <span class="post-item-date"><?= strftime("%b %d, %Y",($article["publishDate"] / 1000)) ?></span>
                  </p>
                  <h3 class="post-item-name">
                    <a class="post-item-link" href="/blog/<?= $article['id'] ?>">
                      <?php echo $article['title'] ?>
                    </a>
                  </h3>
                </section>
              </li>
            <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </div>
  </aside>
</section>
<?= js_tag("frontsite/tab.js") ?>