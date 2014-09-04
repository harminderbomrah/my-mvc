<div class="login-page" data-ng-app="flickrAPI"  data-ng-controller="resets">
  <div class="login">
    <div class="login-inner forgot-password">
      <h1>
        <!-- <i class="fa fa-apple fa-fw"></i> -->
        <div>
          LC Stone
          <p>Forgot Password?</p>
          <small>Enter the email address you used when you joined and we’ll send you instructions to reset your password.</small>
          <small>For security reasons, we do NOT store your password. So rest assured that we will never send your password via email.</small>
        </div>
      </h1>

      <form data-ng-submit='submitEmail()' role="form">
        <div class="form-group has-feedback" data-ng-class="{'has-warning': feedback.show == 1, 'has-error': feedback.show == 2}">
          <label class="control-label">{{feedback.msg}}</label>
          <input type="text" class="form-control input-lg" data-ng-model="email" placeholder="Email Address">
          <span class="glyphicon form-control-feedback glyphicon-warning-sign" data-ng-if="feedback.show == 1"></span>
          <span class="glyphicon form-control-feedback glyphicon-remove" data-ng-if="feedback.show == 2"></span>
        </div>
        <button type="submit" class="btn btn-danger btn-lg">Send Reset Instructions</button>
      </form>
    </div>
  </div>
</div>
<?= js_tag("app/backend/controllers/login.js") ?>