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
    <?php foreach ($case["imgs"] as $img) {
       echo img_tag($img->file['original']);
    }?>
  </div>
  <div class="content col-5 col-md-12">
    <section class="content-main">
      <p class="content-header">
        <span class="content-category"><?php echo $case['category'] ?></span>
        <span class="content-location"><?php echo $case['location'] ?></span>
        <span class="content-date"><?= $case["date"] ?></span>
      </p>
      <h1 class="content-title"><?php echo $case['title'] ?></h1>
      <article class="content-depiction">
        <?php echo $case['content'] ?>
      </article>
      <table class="content-specs row">
        <tbody>
        <?php if($case["designer"]){ ?>
          <tr>
            <th class="col-2">設計師</th>
            <td class="col-10"><?= $case["designer"] ?></td>
          </tr>
        <?php } ?>
        <?php if($case["size"]){ ?>
          <tr>
            <th class="col-2">面積</th>
            <td class="col-10"><?= $case["size"] ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </section>
    <aside>
      <div class="row">
        <?php if(count($case['tags'])) { ?>
        <div class="aside-block tag col-6 col-ms-12">
          <p class="aside-title">Tags</p>
          <ul class="list-inline">
            <?php foreach ($case['tags'] as $tag) { ?>
              <li><a href="#"><?= $tag ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
        <div class="aside-block share <?php if(count($case['tags'])) { echo 'col-6'; } else { echo 'col-12'; } ?> col-ms-12">
          <p class="aside-title">Share</p>
          <ul class="list-inline">
            <li class="fb"><a href="javascript: void(window.open('http://www.facebook.com/share.php?u='.concat(encodeURIComponent(location.href))));"><i class="fa fa-fw fa-facebook"></i></a></li>
            <li class="twitter"><a href="javascript: void(window.open('http://twitter.com/home/?status='.concat(encodeURIComponent(document.title)).concat(' ').concat(encodeURIComponent(location.href))));"><i class="fa fa-fw fa-twitter"></i></a></li>
            <li class="gplus"><a href="https://plus.google.com/share?url={<?= Routes::current_url() ?>}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-fw fa-google-plus"></i></a></li>
          </ul>
        </div>
      </div>
      <?php if(count($case['products'])) { ?>
        <div class="aside-block related">
          <p class="aside-title">Related Products</p>
          <ul class="list-inline row">
            <?php foreach ($case['products'] AS $product) { ?>
              <li class="related-item col-6 col-ms-12">
                <div class="related-image bgimage" <?php if($product['image']!=""){echo 'style="background-image: url('.$product['image']->to_absolute_url().')"';}?>></div>
                <div class="related-info">
                  <p class="related-header">
                    <span class="related-header-category"><?= $product['title'] ?></span>
                  </p>
                  <p class="related-title"><a href="/collections/<?= $product['id'] ?>"><?= $product['depiction'] ?></a></p>
                </div>
              </li>
            <?php } ?>
          </ul>
        </div>
        <?php if(count($case['links'])) { ?>
          <div class="aside-block related">
            <p class="aside-title">Related Links</p>
            <ul class="list-unstyled">
              <?php foreach ($case['links'] AS $link) { ?>
                <li><a href="<?= $link['url'] ?>" target="_blank"><?= $link['name'] ?></a></li>
              <?php } ?>
            </ul>
          </div>
        <?php } ?>
      <?php } ?>
    </aside>
    <div class="pagenavi">
      <?php if($case["previous_id"] != null) { ?><a href="/case-study/<?= $case['previous_id'] ?>"><i class="fa fa-fw fa-arrow-left"></i> PREV</a><?php }?><?php if($case["next_id"] != null) { ?><a href="/case-study/<?= $case['next_id'] ?>">NEXT <i class="fa fa-fw fa-arrow-right"></i></a><?php }?>
    </div>
  </div>
</div>