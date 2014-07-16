<table>
  <caption><?php echo $case['title'] ?></caption>
  <tbody>
    <tr>
      <td colspan="2">
        <?php echo img_tag($img); ?>
      </td>
    </tr>
    <tr>
      <th>Content</th>
      <td><pre><?php echo $case['content'] ?></pre></td>
    </tr>
     <tr>
      <th>Location</th>
      <td><?php echo $case['location'] ?></td>
    </tr>
    <tr>
      <th>Category</th>
      <td><?php echo $case['category'] ?></td>
    </tr>
    <tr>
      <th>Tags</th>
      <td>
        <ul>
          <?php foreach ($case['tags'] as $tag) { ?>
            <li><?= $tag ?></li>
          <?php } ?>
        </ul>
      </td>
    </tr>
    <tr>
      <th>Product</th>
      <td>
        <?php 
        foreach ($case['products'] AS $product) { ?>
           <ul>
             <li><a href="/product/<?= $product['id'] ?>"><?= $product['title'] ?></a></li>
           </ul>
        <?php } ?>
      </td>
    </tr>
    <tr>
      <th>Link</th>
      <td>
        <?php 
        foreach ($case['links'] AS $link) { ?>
           <ul>
             <li><a href="<?= $link['url'] ?>" target="_blank"><?= $link['name'] ?></a></li>
           </ul>
        <?php } ?>
      </td>
    </tr>
  </tbody>
</table>