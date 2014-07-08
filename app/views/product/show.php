<table>
  <caption><?php echo $product['title'] ?></caption>
  <tbody>
    <tr>
      <th>Depiction</th>
      <td><pre><?php echo $product['depiction'] ?></pre></td>
    </tr>
    <tr>
      <th>Category</th>
      <td><?php echo $product['category'] ?></td>
    </tr>
    <tr>
      <th>Tags</th>
      <td><?php echo $product['tags'] ?></td>
    </tr>
    <tr>
      <th>Specs</th>
      <td>
        <?php foreach ($product['specs'] AS $spec) { ?>
           <table>
             <tr>
               <th><?php echo $spec['item'] ?></th>
               <td><?php echo $spec['detail'] ?></td>
             </tr>
           </table>
        <?php } ?>
      </td>
    </tr>
  </tbody>
</table>