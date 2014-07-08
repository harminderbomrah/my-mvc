<!DOCTYPE html>
<html lang="en">
  <?= render_partial("partial/home-head") ?>
  <body>

    <div style="font-family: arial; height: 30px;">
      <div style="float: left; font-weight: bold;"><a href="/">LC Stone</a></div> 
      <div style="float: right;">
        <?php if($loggedin) { ?>
          <a href="/admin">Dashboard</a>
          <a href="/user/logout">Logout</a>
        <?php }else{ ?>
          <a href="/user/login">Login</a>
        <?php }?>
      </div>
    </div>

    <?= render_partial("partial/main-menu") ?>

    <?= $yield ?>
  </body>
</html>