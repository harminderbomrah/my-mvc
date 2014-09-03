<?= content_css_tag("frontsite/unit/show.scss") ?>
<?= render_partial("partial/top-nav") ?>
<div class="main-wrap border-bottom show show-blog">
  <div class="content">
    <section class="content-main">
      <div class="content-top bgimage" <?php if($article["img"]) { echo 'style="background-image: url('.$article["img"]->file["original"]->to_absolute_url().')"'; }?>>
        <div class="content-top-inner">
          <p class="content-header">
            <span class="content-category"><?= $article['category'] ?></span>
            <span class="content-date"><?= $article["date"] ?></span>
          </p>
          <h1><?php echo $article['title'] ?></h1>
        </div>
      </div>
      <article>
        <?php echo $article['content'] ?>
      </article>
    </section>
    <aside>
      <div class="row">
        <?php if(count($article['tags'])) { ?>
          <div class="aside-block tag col-6 col-ms-12">
            <p class="aside-title">標籤</p>
            <ul class="list-inline">
              <?php foreach ($article['tags'] as $tag) { ?>
                <li><a href="#"><?= $tag ?></a></li>
              <?php } ?>
            </ul>
          </div>
        <?php } ?>
        <div class="aside-block share <?php if(count($article['tags'])) { echo 'col-6'; } else { echo 'col-12'; } ?> col-ms-12">
          <p class="aside-title">社群分享</p>
          <ul class="list-inline">
            <li class="fb"><a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href))));"><i class="fa fa-fw fa-facebook"></i></a></li>
            <li class="twitter"><a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)).concat(' ').concat(encodeURIComponent(location.href))));"><i class="fa fa-fw fa-twitter"></i></a></li>
            <li class="gplus"><a href="https://plus.google.com/share?url={<?= Routes::current_url() ?>}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-fw fa-google-plus"></i></a></li>
          </ul>
        </div>
      </div>
      <?php if(count($article['products'])) { ?>
        <div class="aside-block related">
          <p class="aside-title">相關產品</p>
          <ul class="list-inline row">
            <?php foreach ($article['products'] AS $product) { ?>
              <li class="related-item col-6 col-ms-12">
                <div class="related-image bgimage" <?php if($product['image']!=""){echo 'style="background-image: url('.$product['image']->to_absolute_url().')"';}?>>
                  <a class="image-link" href="/collections/<?= $product['id'] ?>"></a>
                </div>
                <div class="related-info">
                  <p class="related-header">
                    <span class="related-header-category"><?= $product["category"] ?></span>
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
          <p class="aside-title">相關案件</p>
          <ul class="list-inline row">
            <?php foreach ($article['cases'] AS $case) { ?>
              <li class="related-item col-6 col-ms-12">
                <div class="related-image bgimage" <?php if($case['image']!=""){echo 'style="background-image: url('.$case['image']->to_absolute_url().')"';}?>>
                  <a class="image-link" href="/case-study/<?= $case['id'] ?>"></a>
                </div>
                <div class="related-info">
                  <p class="related-header">
                    <span class="related-header-location"><?= $case["location"] ?></span>
                    <span class="related-header-date"><?= $case["date"] ?></span>
                  </p>
                  <p class="related-title"><a href="/case-study/<?= $case['id'] ?>"><?= $case['title'] ?></a></p>
                </div>
              </li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>
      <?php if(count($article['links'])) { ?>
        <div class="aside-block related">
          <p class="aside-title">相關連結</p>
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
   <?php if($previous_article) { ?>
    <div class="pagenavi-itme bgimage <?php if(!$next_article) { echo "col-12"; } else { echo "col-6"; } ?>" <?php if($previous_article["img"]) { echo 'style="background-image: url('.$previous_article["img"]->file["medium"]->to_absolute_url().')"'; }?>>
      <p class="arrow">
        <a href="/blog/<?= $previous_article['id'] ?>"><i class="fa fa-fw fa-arrow-left"></i> PREV </a>
      </p>
      <p class="pagenavi-itme-header">
        <span class="pagenavi-itme-category"><?= $previous_article["category"] ?></span>
        <span class="pagenavi-itme-date"><?= $previous_article["date"] ?></span>
      </p>
      <h4 class="pagenavi-itme-name">
        <a class="pagenavi-itme-link" href="/blog/<?= $previous_article['id'] ?>">
          <?=  $previous_article['title'] ?>
        </a>
      </h4>
    </div>
  <?php } ?>
  <?php if($next_article) { ?>
    <div class="pagenavi-itme bgimage <?php if(!$previous_article) { echo "col-12"; } else { echo "col-6"; } ?>"  <?php if($next_article["img"]) { echo 'style="background-image: url('.$next_article["img"]->file["medium"]->to_absolute_url().')"'; }?>>
      <p class="arrow">
        <a href="/blog/<?= $next_article['id'] ?>"> NEXT <i class="fa fa-fw fa-arrow-right"></i></a>
      </p>
      <p class="pagenavi-itme-header">
        <span class="pagenavi-itme-category"><?= $next_article["category"] ?></span>
        <span class="pagenavi-itme-date"><?= $next_article["date"] ?></span>
      </p>
      <h4 class="pagenavi-itme-name">
        <a class="pagenavi-itme-link" href="/blog/<?= $next_article["id"] ?>">
          <?= $next_article['title'] ?>
        </a>
      </h4>
    </div>
  <?php } ?>
  </div>
  <div class="related-post">
    <div class="related-post-inner">
      <p class="related-post-title">相關文章</p>
      <ul class="list-inline related-post-list row">
      <?php foreach ($related_articles as $rarticle) {?>
         <li class="related-post-item col-3 col-ms-12">
          <div class="related-post-item-image bgimage" <?php if($rarticle["img"]) { echo 'style="background-image: url('.$rarticle["img"]->file["medium"]->to_absolute_url().')"'; }?>>
            <a class="image-link" href="/blog/<?= $previous_article['id'] ?>"></a>
          </div>
          <p class="related-post-item-header">
            <span class="related-post-item-category"><?= $rarticle["category"] ?></span>
            <span class="related-post-item-date"><?= $rarticle["date"] ?></span>
          </p>
          <h5 class="related-post-item-title">
            <a href="/blog/<?= $rarticle["id"] ?>"><?= $rarticle["title"] ?></a>
          </h5>
        </li>
      <?php } ?>
      </ul>
    </div>
  </div>
  <div id="disqus_thread"></div>
  <script type="text/javascript">
      /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
      var disqus_shortname = 'lcstone'; // required: replace example with your forum shortname

      /* * * DON'T EDIT BELOW THIS LINE * * */
      (function() {
          var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
          dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
          (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
      })();
  </script>
  <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
  <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
</div>
