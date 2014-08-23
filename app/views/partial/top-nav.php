<div class="top-nav">
  <div class="top-nav-list">
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li><a href="#">Library</a></li>
      <li class="active">Data</li>
    </ol>
    <ol class="view-swich">
      <?php if($filter && ($_COOKIE['listView'] == 'block' || $_COOKIE['listView'] != true)) { ?>
      <li class="open-filter">篩選類型 <i class="fa fa-fw fa-angle-down"></i></li>
      <?php } ?>
      <?php if($viewSwich) { ?>
      <li class="view <?php if($_COOKIE['listView'] == 'block' || $_COOKIE['listView'] != true) echo 'active' ?>" data-cookie="block"><i class="fa fa-fw fa-th"></i></li>
      <li class="view <?php if($_COOKIE['listView'] == 'list') echo 'active' ?>" data-cookie="list"><i class="fa fa-fw fa-bars"></i></li>
      <?php } ?>
    </ol>
  </div>
  <div class="filter-box">
    <ul class="filter-box-inner row list-inline">
      <li class="col-6 col-md-12">
        <p class="header">類別篩選</p>
        <ul class="list-unstyled cat row">
          <?php foreach ($categories as $category) { ?>
            <li class="col-6 col-lg-4"><a href="<?= strtok($_SERVER["REQUEST_URI"],'?') ?>?category=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
          <?php } ?>
        </ul>
      </li>
      <li class="col-6 col-md-12">
        <p class="header">標籤分類</p>
        <ul class="list-inline">
          <?php foreach (Tags::all_with_quantity() as $tag) { ?>
            <li><a href="<?= strtok($_SERVER["REQUEST_URI"],'?') ?>?tag=<?= $tag['id'] ?>"><?= $tag['name'] ?></a></li>
          <?php } ?>
        </ul>
      </li>
    </ul>
  </div>
</div>
<script>
  $('.view-swich').on('click', 'li', function(event) {
    if($(this).hasClass('view')) {
      document.cookie = "listView=" + $(this).data('cookie') + ";";
      location.reload();
    }
    if($(this).hasClass('open-filter')) {
      $('.filter-box').toggleClass('open');
      $(this).toggleClass('active');
      $('body').on('click', function(event) {
        var $el = $(event.target);
        if(!$el.closest('div').hasClass('filter-box') && !$el.closest('li').hasClass('open-filter')) {
          $('.filter-box').toggleClass('open');
          $('.open-filter').toggleClass('active');
          $('body').off('click');
        }
      });
    }
    $('.filter-box').perfectScrollbar()
    event.preventDefault();
  });
</script>