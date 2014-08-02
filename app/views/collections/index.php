<table>
  <caption><h3>Product List</h3></caption>
  <thead>
    <tr>
      <th>Category</th>
      <th>Title</th>
      <th>Tag</th>
      <th>Image</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $product) { ?>
      <tr>
        <td>
          <?php echo $product['category_name'] ?>
        </td>
        <td>
          <a href="/collections/<?php echo $product['id'] ?>">
            <?php echo $product['name'] ?>
          </a>
        </td>
         <td>
          <?= img_tag($product["image"]) ?>
        </td>
        <td>
          <?php foreach ($product['tags'] as $tag) { ?>
            <i><?php echo $tag['name']; ?></i>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>