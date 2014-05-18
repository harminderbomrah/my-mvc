<!DOCTYPE html>
<html lang="en">
  <?= render_partial("partial/head") ?>
  <body data-ng-app="nyfnApp">
    <?= render_partial("partial/headbar") ?>
    <div class="main-container" id="main-container">
      <div class="main-container-inner">
        <?= render_partial("partial/sidebar") ?>
        <div class="main-content">
          <?= render_partial("partial/page-content-top-bar") ?>
          <div class="page-content">
            <div class="page-content-inner">
              <?= $yield ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>