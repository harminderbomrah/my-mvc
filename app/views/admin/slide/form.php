<?= content_css_tag("plugin/chosen.scss") ?>
<?= content_css_tag("backsite/unit/form.scss") ?>
<div class="main-form" data-ng-controller="slideForm" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <form class="form-horizontal" name="slideForm" data-ng-submit="action.submit(slideForm)" role="form" novalidate>
    <div class="row">
      <div class="col-lg-12">
        <div class="form-group" data-ng-class="{'has-error': slideForm.title.$invalid && !slideForm.title.$pristine}">
          <input type="text" class="form-control input-lg" name="title" id="title" placeholder="標題" data-ng-model="slideData.title" required>
        </div>
        <div class="form-group">
          <div class="panel panel-default">
            <div class="panel-heading">
              <label>內容</label>
            </div>
            <div class="panel-body">
              <textarea class="form-control" rows="5" name="content" id="content" data-ng-model="slideData.content"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="panel panel-default" data-ng-class="{'panel-danger': slideForm.imgLeft.$invalid && !slideForm.imgLeft.$pristine}">
          <div class="panel-heading">
            <label>左側圖片</label>
          </div>
          <div class="panel-body">
            <a class="upload" href="#" data-ng-click="action.fileUpLoad('left')">
              <i class="fa fa-upload fa-5x fa-fw" data-ng-show="!slideData.imgLeft"></i>
              <div class="img" data-ng-show="slideData.imgLeft">
                <i class="fa fa-refresh fa-5x fa-fw"></i>
                <img class="img-rounded" data-ng-src="{{initial.previewLeft}}">
                <input type="hidden" name="imgLeft" data-ng-model="slideData.imgLeft" required>
              </div>
            </a>
            <div class="clearImg">
              <button type="button" class="btn btn-sm btn-flat btn-warning" data-ng-click="action.clearImg('left')" data-ng-show="slideData.imgLeft">清除圖片</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel panel-default" data-ng-class="{'panel-danger': slideForm.imgRight.$invalid && !slideForm.imgRight.$pristine}">
          <div class="panel-heading">
            <label>右側圖片</label>
          </div>
          <div class="panel-body">
            <a class="upload" href="#" data-ng-click="action.fileUpLoad('right')">
              <i class="fa fa-upload fa-5x fa-fw" data-ng-show="!slideData.imgRight"></i>
              <div class="img" data-ng-show="slideData.imgRight">
                <i class="fa fa-refresh fa-5x fa-fw"></i>
                <img class="img-rounded" data-ng-src="{{initial.previewRight}}">
                <input type="hidden" name="imgRight" data-ng-model="slideData.imgRight" required>
              </div>
            </a>
            <div class="clearImg">
              <button type="button" class="btn btn-sm btn-flat btn-warning" data-ng-click="action.clearImg('right')" data-ng-show="slideData.imgRight">清除圖片</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>狀態</label>
          </div>
          <div class="panel-body">
            <div class="form-group" data-ng-class="{'has-error': slideForm.series.$invalid && !slideForm.series.$pristine}">
              <select class="form-control" name="series" id="series" data-placeholder="選擇系列" data-ng-model="slideData.series" data-ng-options="option.class as option.name for option in initial.series" chosen="choseOptions" required>
                <option value=""></option>
              </select>
              <label for="series" class="control-label">系列</label>
            </div>
            <div class="form-group">
              <label for="disabled" class="control-label">是否發佈</label>
              <div class="switch reverse">
                <input type="checkbox" name="disabled" id="disabled" class="switch-input" data-ng-model="slideData.disabled">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="publishDate" class="control-label">發佈日期</label>
              <div class="switch">
                <input type="checkbox" name="publishDate" id="publishDate" class="switch-input" data-ng-model="initial.publishDate" data-ng-click="action.datepicker.clear(initial.publishDate, 'publish')">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
              <div class="input-group" data-ng-class="{'hide': !initial.publishDate, 'has-error': slideForm.publishDate.$invalid && !slideForm.publishDate.$pristine}">
                <input type="text" name="publishDate" class="form-control" data-ng-model="slideData.publishDate" data-ng-required="initial.publishDate" is-open="openedPuplish" min-date="initial.editPublishDate || initial.today" max-date="slideData.endDate" datepicker-popup="yyyy-MM-dd" show-button-bar="false" datepicker-options="dateOptions" />
                <span class="input-group-btn">
                  <button class="btn btn-default" data-ng-click="action.datepicker.open($event, 'publish')"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
            <div class="form-group">
              <label for="endDate" class="control-label">結束日期</label>
              <div class="switch">
                <input type="checkbox" name="endDate" id="endDate" class="switch-input" data-ng-model="initial.endDate" data-ng-click="action.datepicker.clear(initial.endDate, 'end')">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
              <div class="input-group" data-ng-class="{'hide': !initial.endDate, 'has-error': slideForm.endDate.$invalid && !slideForm.endDate.$pristine}">
                <input type="text" name="endDate" class="form-control" data-ng-disabled="!initial.publishDate" data-ng-model="slideData.endDate" data-ng-required="initial.endDate" is-open="openedEnd" min-date="slideData.publishDate || initial.today" datepicker-popup="yyyy-MM-dd" show-button-bar="false" datepicker-options="dateOptions" />
                <span class="input-group-btn">
                  <button class="btn btn-default" data-ng-disabled="!initial.publishDate" data-ng-click="action.datepicker.open($event, 'end')"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
          </div>
          <div class="panel-footer text-right">
            <a class="btn btn-sm btn-default" href="/admin/slide" target="_self">取消</a>
            <button type="submit" class="btn btn-sm btn-primary" data-ng-disabled="initial.submit">送出</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?= js_tag("app/backend/controllers/slide-form.js") ?>
<?= js_tag("app/backend/controllers/fileManage/defaultFileManage.js") ?>
<?= js_tag("plugin/ngFileUpload/angular-file-upload.js") ?>
<?= js_tag("plugin/masonry/angular-masonry.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>