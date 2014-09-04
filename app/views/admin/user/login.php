<div class="login-page" data-ng-app="flickrAPI"  data-ng-controller="login">
  <div class="login">
    <div class="login-inner signup">
      <h1>
        <!-- <i class="fa fa-apple fa-fw"></i> -->
        <div>LC Stone</div>
      </h1>
      <div class="panel panel-default">
        <div class="panel-body">
          <form action='/login/check' method="post" role="form">
            <div class="form-group">
              <label class="sr-only">Email address</label>
              <input type="text" class="form-control input-lg" name="username" placeholder="Username">
            </div>
            <div class="form-group">
              <label class="sr-only">Password</label>
              <input type="password" class="form-control input-lg" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">登入</button>
          </form>
          <a class="forgot-password hide" href="/user/resets">Forgot password</a>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-slide" ng-style="photo.backgroundImg()">
    <div class="author">Posted by <span>{{photo.ownername}}</span></div>
  </div>
</div>
<?= js_tag("app/backend/controllers/login.js") ?>