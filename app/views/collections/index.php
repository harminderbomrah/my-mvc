<?= content_css_tag("frontsite/unit/list.scss") ?>
<?= render_partial("partial/top-nav") ?>
<section class="main-wrap mini-height border-bottom main-list list-collections">
  <ui class="row list-unstyled">
    <li class="list-first col-3 col-lg-2 col-md-4 col-ms-12 col-xs-12">
      <h3 class="list-title content-title" title="<?= $products[0]['category_name'] ?>"><?= $products[0]['category_name'] ?></h3>
      <p class="list-description" data-lorem="5s"></p>
    </li>
    <?php foreach ($products as $product) { ?>
      <li class="list-item col-3 col-lg-2 col-md-4 col-ms-12 col-xs-12" style="background-image: url(<?= $product['image']->to_absolute_url() ?>)">
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