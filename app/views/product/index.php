<div>
  <h3>Category</h3>
  <ul>
    <?php foreach ($categories as $category) { ?>
      <?php if($category['id']==$_GET['category']) $active = "active"; ?>
      <li class="<?php echo $active ?>">
        <a href="?category=<?php echo $category['id'] ?>">
          <?php echo $category['name'] ?>  
        </a>
      </li>
    <?php } ?>
  </ul>
</div>

<table>
  <caption><h3>Product List</h3></caption>
  <thead>
    <tr>
      <th>Category</th>
      <th>Title</th>
      <th>Tag</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $product) { ?>
      <tr>
        <td>
          <?php echo $product['category_name'] ?>
        </td>
        <td>
          <a href="/product/<?php echo $product['id'] ?>">
            <?php echo $product['name'] ?>
          </a>
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