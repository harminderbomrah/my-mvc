<table>
  <caption><h3>Case List</h3></caption>
  <thead>
    <tr>
      <th>Title</th>
      <th>Category</th>
      <th>Tags</th>
      <th>Image</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($cases as $case) { ?>
      <tr>
        <td>
          <?php echo Category::find($case['category'])->name ?>
        </td>
        <td>
          <a href="/case/<?php echo $case['id'] ?>">
            <?php echo $case['title'] ?>
          </a>
        </td>
        <td>
          <?= img_tag($case["image"]) ?>
        </td>
        <td>
          <?php foreach ($case['tags'] as $tag) { ?>
            <i><?php echo $tag['name']; ?></i>
          <?php } ?>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>