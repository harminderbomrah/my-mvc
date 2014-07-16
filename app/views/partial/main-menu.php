<ul>
  <li>
    <a href="/product">Product</a>
    <ul>
      <?php 
      $categories = Category::all_with_quantity('product');
      foreach ($categories as $category) { ?>
        <li><a href="/product?category=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
      <?php } ?>
    </ul>
  </li>
  <li>
    <a href="/article">Article</a>
    <ul>
      <?php 
      $categories = Category::all_with_quantity('article');
      foreach ($categories as $category) { ?>
        <li><a href="/article?category=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
      <?php } ?>
    </ul>
  </li>
  <li>
    <a href="/case">Case</a>
    <ul>
      <?php 
      $categories = Category::all_with_quantity('case');
      foreach ($categories as $category) { ?>
        <li><a href="/case?category=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
      <?php } ?>
    </ul>
  </li>
</ul>