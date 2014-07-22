<!DOCTYPE html>
<html lang="en">
  <?= render_partial("partial/home-head") ?>
  <body>

    <div>
      <div><a href="/">LC Stone</a></div>
      <div>
        <?php if($current_user->loggedin) { ?>
          <a href="/admin">Dashboard</a>
          <a href="/user/logout">Logout</a>
        <?php }else{ ?>
          <a href="/user/login">Login</a>
        <?php }?>
      </div>
    </div>

    <?= render_partial("partial/main-menu") ?>

    <?= $yield ?>
    <?= render_partial("partial/footer") ?>
  </body>
</html>