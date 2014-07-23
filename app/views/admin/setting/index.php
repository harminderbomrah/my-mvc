<?= content_css_tag("backsite/unit/site-setting.scss") ?>
<div data-ng-controller="siteSettingForm" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <div class="row">
    <form class="form-horizontal col-lg-6" name="settingForm" data-ng-submit="setSubmit(settingForm)" role="form" novalidate>
      <div class="form-warp">
        <h4 class="form-warp-title">Site Information</h4>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="site-title">Site Title</label>
          <div class="col-sm-9" data-ng-class="{'has-error': settingForm.siteTitle.$invalid && !settingForm.siteTitle.$pristine}">
            <input type="text" class="form-control" name="siteTitle" id="site-title" data-ng-model="siteInfo.title" required>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="description">Site Description</label>
          <div class="col-sm-9">
            <textarea class="form-control" name="description" id="description" data-ng-model="siteInfo.description" rows="5"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </form>
    <form class="form-horizontal col-lg-6" name="passwordForm" data-ng-submit="passwordSubmit(passwordForm)" role="form" novalidate>
      <div class="form-warp">
        <h4 class="form-warp-title">Change Password</h4>
        <div class="form-group {{pswold[0]}} has-feedback">
          <label class="col-sm-3 control-label" for="oldPassword">Old Password</label>
          <div class="col-sm-9">
            <input type="password" class="form-control" name="oldPassword" id="oldPassword" data-ng-model="psw.old" data-ng-blur="checkPassword(passwordForm, 'old')" placeholder="Old Password" required>
            <span class="glyphicon {{pswold[1]}} form-control-feedback"></span>
            <p class="msg text-warning" data-ng-show="oldmsg">{{oldmsg}}</p>
          </div>
        </div>
        <div class="form-group {{pswnew[0]}} has-feedback">
          <label class="col-sm-3 control-label" for="newPassword">New Password</label>
          <div class="col-sm-9">
            <input type="password" class="form-control" name="newPassword" id="newPassword" data-ng-model="psw.new" data-ng-blur="checkPassword(passwordForm, 'new')" placeholder="New Password" required>
            <span class="glyphicon {{pswnew[1]}} form-control-feedback"></span>
            <p class="msg text-danger" data-ng-show="newmsg">{{newmsg}}</p>
          </div>
        </div>
        <div class="form-group {{pswconf[0]}} has-feedback">
          <label class="col-sm-3 control-label" for="confirmPassword">Confirm Password</label>
          <div class="col-sm-9">
            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" data-ng-model="psw.conf" data-ng-blur="checkPassword(passwordForm, 'conf')" placeholder="Confirm Password">
            <span class="glyphicon {{pswconf[1]}} form-control-feedback"></span>
            <p class="msg text-danger" data-ng-show="confmsg">{{confmsg}}</p>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-sm btn-primary" data-ng-disabled="pswSubmit">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<?= js_tag("app/backend/controllers/site-setting.js") ?>