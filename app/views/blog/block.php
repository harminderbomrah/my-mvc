<section class="main-wrap mini-height border-bottom main-block list-blog">
  <ui class="row list-unstyled">
    <?php if($_GET['category']){ ?>
    <li class="list-first col-3 col-lg-2 col-md-4 col-ms-12 col-xs-12">
      <h3 class="list-title content-title" title="<?= Category::find($_GET['category'])->name ?>"><?= Category::find($_GET['category'])->name ?></h3>
      <p class="list-description"><?= Category::find($_GET['category'])->description ?></p>
    </li>
    <?php } ?>
    <?php foreach ($articles as $article) { ?>
      <li class="list-item col-ms-12 col-xs-12 <?php if($article['hot']) { echo 'col-6 col-lg-4 col-md-8'; } else { echo 'col-3 col-lg-2 col-md-4'; }?>" <?php if($article['image']!=""){echo 'style="background-image: url('.$article['image']->to_absolute_url().')"';}?>>
        <a class="list-item-link" href="/blog/<?= $article['id'] ?>">
          <span class="list-item-info">
            <span class="list-item-date">APR 20, 2014</span>
            <span class="list-item-name"><?= $article['title'] ?></span>
          </span>
        </a>
      </li>
    <?php } ?>
  </ui>
</section>