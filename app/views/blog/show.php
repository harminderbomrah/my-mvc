<?= content_css_tag("frontsite/unit/show.scss") ?>
<?= render_partial("partial/top-nav") ?>
<div class="main-wrap border-bottom show show-blog">
  <div class="content">
    <section class="content-main">
      <div class="content-top" <?php if($img) { echo 'style="background-image: url('.$img->to_absolute_url().')"'; }?>>
        <p class="content-header">
          <span class="content-category"><?php echo $article['category'] ?></span>
        </p>
        <h1><?php echo $article['title'] ?></h1>
      </div>
      <article>
        
      </article>
    </section>
  </div>
</div>
<table>
  <caption><?php echo $article['title'] ?></caption>
  <tbody>
    <tr>
      <td colspan="2">
        <?php echo img_tag($img); ?>
      </td>
    </tr>
    <tr>
      <th>Content</th>
      <td><pre><?php echo $article['content'] ?></pre></td>
    </tr>
    <tr>
      <th>Category</th>
      <td><?php echo $article['category'] ?></td>
    </tr>
    <tr>
      <th>Tags</th>
      <td>
        <ul>
          <?php foreach ($article['tags'] as $tag) { ?>
            <li><?= $tag ?></li>
          <?php } ?>
        </ul>
      </td>
    </tr>
    <tr>
      <th>Product</th>
      <td>
        <?php 
        foreach ($article['products'] AS $product) { ?>
           <ul>
             <li><a href="/product/<?= $product['id'] ?>"><?= $product['title'] ?></a></li>
           </ul>
        <?php } ?>
      </td>
    </tr>
    <tr>
      <th>Case</th>
      <td>
        <?php 
        foreach ($article['cases'] AS $case) { ?>
           <ul>
             <li><a href="/case/<?= $case['id'] ?>"><?= $case['title'] ?></a></li>
           </ul>
        <?php } ?>
      </td>
    </tr>
    <tr>
      <th>Link</th>
      <td>
        <?php 
        foreach ($article['links'] AS $link) { ?>
           <ul>
             <li><a href="<?= $link['url'] ?>" target="_blank"><?= $link['name'] ?></a></li>
           </ul>
        <?php } ?>
      </td>
    </tr>
  </tbody>
</table>