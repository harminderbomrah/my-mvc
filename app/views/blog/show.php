<?= content_css_tag("frontsite/unit/show.scss") ?>
<?= render_partial("partial/top-nav") ?>
<div class="main-wrap border-bottom show show-blog">
  <div class="content">
    <section class="content-main">
      <div class="content-top bgimage" <?php if($img) { echo 'style="background-image: url('.$img->to_absolute_url().')"'; }?>>
        <div class="content-top-inner">
          <p class="content-header">
            <span class="content-category"><?php echo $article['category'] ?></span>
            <span class="content-date">Apr 20, 2014</span>
          </p>
          <h1><?php echo $article['title'] ?></h1>
        </div>
      </div>
      <article>
        <?php echo $article['content'] ?></pre>
      </article>
    </section>
    <aside>
      <div class="row">
        <?php if(count($article['tags'])) { ?>
          <div class="aside-block tag col-6 col-ms-12">
            <p class="aside-title">Tags</p>
            <ul class="list-inline">
              <?php foreach ($article['tags'] as $tag) { ?>
                <li><a href="#"><?= $tag ?></a></li>
              <?php } ?>
            </ul>
          </div>
        <?php } ?>
        <div class="aside-block share <?php if(count($article['tags'])) { echo 'col-6'; } else { echo 'col-12'; } ?> col-ms-12">
          <p class="aside-title">Share</p>
          <ul class="list-inline">
            <li class="fb"><a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href))));"><i class="fa fa-fw fa-facebook"></i></a></li>
            <li class="twitter"><a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)).concat(' ').concat(encodeURIComponent(location.href))));"><i class="fa fa-fw fa-twitter"></i></a></li>
            <li class="gplus"><a href="https://plus.google.com/share?url={<?= Routes::current_url() ?>}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-fw fa-google-plus"></i></a></li>
          </ul>
        </div>
      </div>
      <?php if(count($article['products'])) { ?>
        <div class="aside-block related">
          <p class="aside-title">Related Products</p>
          <ul class="list-inline row">
            <?php foreach ($article['products'] AS $product) { ?>
              <li class="related-item col-6 col-ms-12">
                <div class="related-image bgimage" <?php if($product['image']!=""){echo 'style="background-image: url('.$product['image']->to_absolute_url().')"';}?>></div>
                <div class="related-info">
                  <p class="related-header">
                    <span class="related-header-category">category</span>
                  </p>
                  <p class="related-title"><a href="/collections/<?= $product['id'] ?>"><?= $product['title'] ?></a></p>
                </div>
              </li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>
      <?php if(count($article['cases'])) { ?>
        <div class="aside-block related">
          <p class="aside-title">Related Cases</p>
          <ul class="list-inline row">
            <?php foreach ($article['cases'] AS $case) { ?>
              <li class="related-item col-6 col-ms-12">
                <div class="related-image bgimage" <?php if($case['image']!=""){echo 'style="background-image: url('.$case['image']->to_absolute_url().')"';}?>></div>
                <div class="related-info">
                  <p class="related-header">
                    <span class="related-header-location">location</span>
                    <span class="related-header-date">Apr 20, 2014</span>
                  </p>
                  <p class="related-title"><a href="/collections/<?= $case['id'] ?>"><?= $case['title'] ?></a></p>
                </div>
              </li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>
      <?php if(count($article['links'])) { ?>
        <div class="aside-block related">
          <p class="aside-title">Related Links</p>
          <ul class="list-unstyled">
            <?php foreach ($article['links'] AS $link) { ?>
              <li><a href="<?= $link['url'] ?>" target="_blank"><?= $link['name'] ?></a></li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>
    </aside>
  </div>
  <div class="pagenavi row">
    <div class="col-6 pagenavi-itme bgimage"  <?php if($img) { echo 'style="background-image: url('.$img->to_absolute_url().')"'; }?>>
      <p class="arrow">
        <a href="/blog/<?= $case['previous_id'] ?>"><i class="fa fa-fw fa-arrow-left"></i> PREV</a>
      </p>
      <p class="pagenavi-itme-header">
        <span class="pagenavi-itme-category">category</span>
        <span class="pagenavi-itme-date">Apr 04, 2014</span>
      </p>
      <h4 class="pagenavi-itme-name">
        <a class="pagenavi-itme-link" href="/blog/<?= $article['id'] ?>">
          <?php echo $article['title'] ?>
        </a>
      </h4>
    </div>
    <div class="col-6 pagenavi-itme bgimage"  <?php if($img) { echo 'style="background-image: url('.$img->to_absolute_url().')"'; }?>>
      <p class="arrow">
        <a href="/blog/<?= $case['previous_id'] ?>">NEXT <i class="fa fa-fw fa-arrow-right"></i></a>
      </p>
      <p class="pagenavi-itme-header">
        <span class="pagenavi-itme-category">category</span>
        <span class="pagenavi-itme-date">Apr 04, 2014</span>
      </p>
      <h4 class="pagenavi-itme-name">
        <a class="pagenavi-itme-link" href="/blog/<?= $article['id'] ?>">
          <?php echo $article['title'] ?>
        </a>
      </h4>
    </div>
  </div>
  <div class="related-post">
    <div class="related-post-inner">
      <p class="related-post-title">Related Blogs</p>
      <ul class="list-inline related-post-list row">
        <li class="related-post-item col-3 col-ms-12">
          <div class="related-post-item-image bgimage" <?php if($img) { echo 'style="background-image: url('.$img->to_absolute_url().')"'; }?>></div>
          <p class="related-post-item-header">
            <span class="related-post-item-category">category</span>
            <span class="related-post-item-date">APR 20, 2014</span>
          </p>
          <h5 class="related-post-item-title">
            <a href="#">Title</a>
          </h5>
        </li>
        <li class="related-post-item col-3 col-ms-12">
          <div class="related-post-item-image bgimage" <?php if($img) { echo 'style="background-image: url('.$img->to_absolute_url().')"'; }?>></div>
          <p class="related-post-item-header">
            <span class="related-post-item-category">category</span>
            <span class="related-post-item-date">APR 20, 2014</span>
          </p>
          <h5 class="related-post-item-title">
            <a href="#">Title</a>
          </h5>
        </li>
        <li class="related-post-item col-3 col-ms-12">
          <div class="related-post-item-image bgimage" <?php if($img) { echo 'style="background-image: url('.$img->to_absolute_url().')"'; }?>></div>
          <p class="related-post-item-header">
            <span class="related-post-item-category">category</span>
            <span class="related-post-item-date">APR 20, 2014</span>
          </p>
          <h5 class="related-post-item-title">
            <a href="#">Title</a>
          </h5>
        </li>
        <li class="related-post-item col-3 col-ms-12">
          <div class="related-post-item-image bgimage" <?php if($img) { echo 'style="background-image: url('.$img->to_absolute_url().')"'; }?>></div>
          <p class="related-post-item-header">
            <span class="related-post-item-category">category</span>
            <span class="related-post-item-date">APR 20, 2014</span>
          </p>
          <h5 class="related-post-item-title">
            <a href="#">Title</a>
          </h5>
        </li>
      </ul>
    </div>
  </div>
</div>