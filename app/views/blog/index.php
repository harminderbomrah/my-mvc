<table>
  <caption><h3>Article List</h3></caption>
  <thead>
    <tr>
      <th>Category</th>
      <th>Title</th>
      <th>Tag</th>
      <th>Image</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($articles as $article) { ?>
      <tr>
        <td>
          <?php echo Category::find($article['category'])->name ?>
        </td>
        <td>
          <a href="/blog/<?php echo $article['id'] ?>">
            <?php echo $article['title'] ?>
          </a>
        </td>
        <td>
          <?= img_tag($article["image"]) ?>
        </td>
        <td>
          <?php foreach ($article['tags'] as $tag) { ?>
            <i><?php echo $tag['name']; ?></i>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>