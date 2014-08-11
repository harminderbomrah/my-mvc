<?= content_css_tag("frontsite/unit/list.scss") ?>
<?= render_partial("partial/top-nav") ?>
<section class="main-wrap mini-height border-bottom main-list list-casestudy">
  <ui class="row list-unstyled">
    <?php if($_GET['category']){ ?>
    <li class="list-first col-3 col-lg-2 col-md-4 col-ms-12 col-xs-12">
      <h3 class="list-title content-title" title="<?= Category::find($_GET['category'])->name ?>"><?= Category::find($_GET['category'])->name ?></h3>
      <p class="list-description"><?= Category::find($_GET['category'])->description ?></p>
    </li>
    <?php } ?>
    <?php foreach ($cases as $case) { ?>
      <li class="list-item col-ms-12 col-xs-12 
        <?php if($case['hot']) { ?>
          col-6 col-lg-4 col-md-8
        <?php } else { ?>
          col-3 col-lg-2 col-md-4
        <?php }?>" style="background-image: url(<?php if($case['image']!=""){echo $case['image']->to_absolute_url();} ?>)">
        <a class="list-item-link" href="/case-study/<?= $case['id'] ?>">
          <span class="list-item-cover">
            <span class="list-item-location">KAOSHOUNG</span>
            <span class="list-item-date">APR 20, 2014</span>
          </span>
          <span class="list-item-info">
            <span class="list-item-name"><?php echo $case['title'] ?></span>
          </span>
        </a>
      </li>
    <?php } ?>
  </ui>
</section>
<?= render_partial("partial/pagination") ?>