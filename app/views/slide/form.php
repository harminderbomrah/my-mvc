<?= content_css_tag("nyfm/unit/form.scss") ?>
<div class="main-form" data-ng-controller="slideForm" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <form class="form-horizontal" name="slideForm" data-ng-submit="action.submit(slideForm)" role="form" novalidate>
    <div class="row">
      <div class="col-lg-12">
        <div class="form-group" data-ng-class="{'has-error': slideForm.title.$invalid && !slideForm.title.$pristine}">
          <input type="text" class="form-control input-lg" name="title" id="title" placeholder="Title" data-ng-model="slideData.title" required>
        </div>
        <div class="form-group">
          <textarea class="form-control" rows="5" name="content" id="content" data-ng-model="slideData.content"></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Images</label>
          </div>
          <div class="panel-body">
            <a class="upload" href="#" data-ng-click="action.fileUpLoad()">
              <i class="fa fa-upload fa-5x fa-fw" data-ng-show="!slideData.img"></i>
              <div class="img" data-ng-show="slideData.img">
                <i class="fa fa-refresh fa-5x fa-fw"></i>
                <img class="img-rounded" data-ng-src="{{initial.preview}}">
              </div>
            </a>
            <div class="clearImg">
              <button type="button" class="btn btn-sm btn-flat btn-warning" data-ng-click="action.clearImg()" data-ng-show="slideData.img">Clear Image</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Status</label>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label for="disabled" class="control-label">Publish</label>
              <div class="switch reverse">
                <input type="checkbox" name="disabled" id="disabled" class="switch-input" data-ng-model="slideData.disabled">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="publishDate" class="control-label">Publish date</label>
              <div class="switch">
                <input type="checkbox" name="publishDate" id="publishDate" class="switch-input" data-ng-model="initial.publishDate" data-ng-click="action.datepicker.clear(initial.publishDate, 'publish')">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
              <div class="input-group" data-ng-class="{'hide': !initial.publishDate, 'has-error': slideForm.date.$invalid && !slideForm.date.$pristine}">
                <input type="text" name="date" class="form-control" data-ng-model="slideData.date" data-ng-required="initial.publishDate" is-open="openedPuplish" min="initial.today" max="slideData.endDate" datepicker-popup="yyyy/MM/dd" show-button-bar="false" datepicker-options="dateOptions" />
                <span class="input-group-btn">
                  <button class="btn btn-default" data-ng-click="action.datepicker.open($event, 'publish')"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="endDate" class="control-label">End date</label>
              <div class="switch">
                <input type="checkbox" name="endDate" id="endDate" class="switch-input" data-ng-model="initial.endDate" data-ng-click="action.datepicker.clear(initial.endDate, 'end')">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
              <div class="input-group" data-ng-class="{'hide': !initial.endDate, 'has-error': slideForm.endDate.$invalid && !slideForm.endDate.$pristine}">
                <input type="text" name="endDate" class="form-control" data-ng-disabled="!initial.publishDate" data-ng-model="slideData.endDate" data-ng-required="initial.endDate" is-open="openedEnd" min="slideData.date" datepicker-popup="yyyy/MM/dd" show-button-bar="false" datepicker-options="dateOptions" />
                <span class="input-group-btn">
                  <button class="btn btn-default" data-ng-disabled="!initial.publishDate" data-ng-click="action.datepicker.open($event, 'end')"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
          </div>
          <div class="panel-footer text-right">
            <a class="btn btn-sm btn-default" href="/admin/slide" target="_self">Cancel</a>
            <button type="submit" class="btn btn-sm btn-primary" data-ng-disabled="initial.submit">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?= js_tag("app/backend/controllers/slide-form.js") ?>
<?= js_tag("app/backend/controllers/fileManage.js") ?>
<?= js_tag("plugin/ngFileUpload/angular-file-upload.js") ?>