<?= content_css_tag("frontsite/unit/list.scss") ?>
<?= render_partial("partial/top-nav") ?>
<?php $_COOKIE['PHPSESSID'] ?>
<section class="main-wrap mini-height border-bottom main-list list-collections">
  <ui class="row list-unstyled">
    <?php if($_GET['category']){ ?>
    <li class="list-first col-3 col-lg-2 col-md-4 col-ms-12 col-xs-12">
      <h3 class="list-title content-title" title="<?= Category::find($_GET['category'])->name ?>"><?= Category::find($_GET['category'])->name ?></h3>
      <p class="list-description"><?= Category::find($_GET['category'])->description ?></p>
    </li>
    <?php } ?>
    <?php foreach ($products as $product) { ?>
      <li class="list-item col-3 col-lg-2 col-md-4 col-ms-12 col-xs-12" style="background-image: url(<?php if($product['image']!=""){echo $product['image']->to_absolute_url();} ?>)">
        <a class="list-item-link" href="/collections/<?php echo $product['id'] ?>">
          <span class="list-item-info">
            <span class="list-item-name"><?php echo $product['name'] ?></span>
          </span>
        </a>
      </li>
    <?php } ?>
  </ui>
</section>
<?= render_partial("partial/pagination") ?>