<?= content_css_tag("frontsite/unit/show.scss") ?>
<?= render_partial("partial/top-nav") ?>
<?php function spacs($n, $v) {
  $t = '';
  for ($i=0; $i < $n; $i++) {
    $t = $t.'<i class="fa fa-fw fa-'.$v.'"></i>';
  }
  echo $t;
}?>
<div class="main-wrap border-bottom row show show-product">
  <div class="image col-7 col-md-12">
    <?php foreach ($imgs as $img) {
      echo img_tag($img);
    } ?>
  </div>
  <div class="content col-5 col-md-12">
    <section class="content-main">
      <p class="content-header">
        <span class="content-category"><?php echo $product['category'] ?></span>
      </p>
      <h1 class="content-title"><?php echo $product['title'] ?></h1>
      <article class="content-depiction">
        <?php echo $product['depiction'] ?>
      </article>
      <table class="content-specs row">
        <tbody>
          <?php foreach ($product['specs'] as $index => $spec) { ?>
          <tr>
            <th class="col-2">
              <?php switch ($spec['item']) {
                case "countryOfOrigin":
                  echo "產地";
                break;
                case "waterAbsorption":
                  echo "吸水率";
                break;
                case "durability":
                  echo "耐用度";
                break;
                case "evaluate":
                  echo "評價";
                break;
                default:
                  // echo $spec['item'];
                break;
              } ?>
            </th>
            <td class="col-10">
              <?php if ($spec['item'] == "countryOfOrigin") {
                echo $spec['detail'];
              } else {
                switch ($spec['item']) {
                  case "waterAbsorption":
                    spacs($spec['detail'], "tint");
                  break;
                  case "durability":
                    spacs($spec['detail'], "shield");
                  break;
                  case "evaluate":
                    spacs($spec['detail'], "star");
                  break;
                  default:
                    // echo $spec['detail'];
                  break;
                }
              } ?>
            </td>
           </tr>
          <?php } ?>
        </tbody>
      </table>
    </section>
    <aside>
      <button class="askbnt btn">加入詢問清單</button>
      <div class="row">
        <?php if(count($product['tags'])) { ?>
          <div class="aside-block tag col-6 col-ms-12">
            <p class="aside-title">Tags</p>
            <ul class="list-inline">
              <?php foreach ($product['tags'] as $tag) { ?>
                <li><a href="/collections/?tag=<?= $tag->id ?>"><?= $tag->name ?></a></li>
              <?php } ?>
            </ul>
          </div>
        <?php } ?>
        <div class="aside-block share <?php if(count($product['tags'])) { echo 'col-6'; } else { echo 'col-12'; } ?> col-ms-12">
          <p class="aside-title">Share</p>
          <ul class="list-inline">
            <li class="fb"><a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href))));"><i class="fa fa-fw fa-facebook"></i></a></li>
            <li class="twitter"><a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)).concat(' ').concat(encodeURIComponent(location.href))));"><i class="fa fa-fw fa-twitter"></i></a></li>
            <li class="gplus"><a href="https://plus.google.com/share?url={http://nowyoufindme.no-ip.org:8888/collections/16}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-fw fa-google-plus"></i></a></li>
          </ul>
        </div>
      </div>
      <?php if(count($product['related_articles'])) { ?>
        <div class="aside-block related">
          <p class="aside-title">Related Articles</p>
          <ul class="list-inline row">
            <?php foreach ($product['related_articles'] as $article) { ?>
              <li class="related-item col-6 col-ms-12">
                <div class="related-image bgimage" <?php if($article['image']!=""){echo 'style="background-image: url('.$article['image']->to_absolute_url().')"';}?>></div>
                <div class="related-info">
                  <p class="related-header">
                    <span class="related-header-category"><?= $article['category'] ?></span>
                    <span class="related-header-date">需要日期</span>
                  </p>
                  <p class="related-title"><a href="/blog/<?= $article['id'] ?>"><?= strip_tags($article['title']) ?></a></p>
                </div>
              </li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>
      <?php if(count($product['related_cases'])) { ?>
        <div class="aside-block related">
          <p class="aside-title">Related Cases</p>
          <ul class="list-inline row">
            <?php foreach ($product['related_cases'] as $case) { ?>
              <li class="related-item col-6 col-ms-12">
                <div class="related-image bgimage" <?php if($case['image']!=""){echo 'style="background-image: url('.$case['image']->to_absolute_url().')"';}?>></div>
                <div class="related-info">
                  <p class="related-header">
                    <span class="related-header-location"><?= $case['location'] ?></span>
                    <span class="related-header-date"><?= $case["date"] ?></span>
                  </p>
                  <p class="related-title"><a href="/case-study/<?= $case['id'] ?>"><?= strip_tags($case['title']) ?></a></p>
                </div>
              </li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>
    </aside>
    <div class="pagenavi">
      <?php if($product["previous_id"] != null) { ?><a href="/collections/<?= $product['previous_id'] ?>"><i class="fa fa-fw fa-arrow-left"></i> PREV</a><?php }?><?php if($product["next_id"] != null) { ?><a href="/collections/<?= $product['next_id'] ?>">NEXT <i class="fa fa-fw fa-arrow-right"></i></a><?php }?>
    </div>
  </div>
</div>