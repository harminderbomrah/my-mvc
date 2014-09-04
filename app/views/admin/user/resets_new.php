<div class="login-page" data-ng-app="flickrAPI"  data-ng-controller="resets">
  <div class="login">
    <div class="login-inner signup">
      <h1>
        <!-- <i class="fa fa-apple fa-fw"></i> -->
        <div>
          LC Stone
          <p>Reset your password</p>
        </div>
      </h1>
      
      <div class="panel panel-default">
        <div class="panel-body">
          <form data-ng-submit='submitPassword()' role="form">
            <div class="form-group has-feedback" data-ng-class="{'has-warning': feedback.show == 1, 'has-error': feedback.show == 2}">
              <label class="control-label" data-ng-show="feedback.show">{{feedback.msg}}</label>
              <input type="password" class="form-control input-lg" data-ng-model="psw.A" name="password" placeholder="Password">
              <span class="glyphicon form-control-feedback glyphicon-warning-sign" data-ng-show="feedback.show == 1"></span>
              <span class="glyphicon form-control-feedback glyphicon-remove" data-ng-show="feedback.show == 2"></span>
            </div>
            <div class="form-group has-feedback" data-ng-class="{'has-warning': feedback.show == 1, 'has-error': feedback.show == 2}">
              <input type="password" class="form-control input-lg" data-ng-model="psw.B" name="password" placeholder="Password Again">
              <span class="glyphicon form-control-feedback glyphicon-warning-sign" data-ng-show="feedback.show == 1"></span>
              <span class="glyphicon form-control-feedback glyphicon-remove" data-ng-show="feedback.show == 2"></span>
            </div>
            <p class="text-center"><small>Minimum 8 characters</small></p>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Reset Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?= js_tag("app/backend/controllers/login.js") ?>