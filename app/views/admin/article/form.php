<?= content_css_tag("plugin/chosen.scss") ?>
<?= content_css_tag("backsite/unit/form.scss") ?>
<div class="main-form" data-ng-controller="articleForm" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <form class="form-horizontal" name="articleForm" data-ng-submit="action.submit(articleForm)" role="form" novalidate>
    <div class="row">
      <div class="col-lg-9">
        <div class="form-group" data-ng-class="{'has-error': articleForm.title.$invalid && !articleForm.title.$pristine}">
          <input type="text" class="form-control input-lg" name="title" id="title" placeholder="標題" data-ng-model="articleData.title" required>
        </div>
        <div class="form-group">
          <textarea class="form-control" name="content" id="content" data-ng-model="articleData.content" ui-tinymce="tinyMceOptions"></textarea>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>類別</label>
          </div>
          <div class="panel-body">
            <div class="form-group" data-ng-class="{'has-error': articleForm.category.$invalid && !articleForm.category.$pristine}">
              <select class="form-control" name="category" id="category" data-placeholder="選擇類別" data-ng-model="articleData.category" data-ng-options="option.id as option.name for option in relationData.categorys" chosen="choseOptions" required>
                <option value=""></option>
              </select>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>狀態</label>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label for="hot" class="control-label">熱門</label>
              <div class="switch">
                <input type="checkbox" name="hot" id="hot" class="switch-input" data-ng-model="articleData.hot">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="top" class="control-label">置頂</label>
              <div class="switch">
                <input type="checkbox" name="top" id="top" class="switch-input" data-ng-model="articleData.top">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="disabled" class="control-label">是否發佈</label>
              <div class="switch reverse">
                <input type="checkbox" name="disabled" id="disabled" class="switch-input" data-ng-model="articleData.disabled">
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
              <div class="input-group" data-ng-class="{'hide': !initial.publishDate, 'has-error': articleForm.publishDate.$invalid && !articleForm.publishDate.$pristine}">
                <input type="text" name="publishDate" class="form-control" data-ng-model="articleData.publishDate" data-ng-required="initial.publishDate" is-open="openedPuplish" min-date="initial.editPublishDate || initial.today" max-date="articleData.endDate" datepicker-popup="yyyy-MM-dd" show-button-bar="false" datepicker-options="dateOptions" />
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
              <div class="input-group" data-ng-class="{'hide': !initial.endDate, 'has-error': articleForm.endDate.$invalid && !articleForm.endDate.$pristine}">
                <input type="text" name="endDate" class="form-control" data-ng-disabled="!initial.publishDate" data-ng-model="articleData.endDate" data-ng-required="initial.endDate" is-open="openedEnd" min-date="articleData.publishDate || initial.today" datepicker-popup="yyyy-MM-dd" show-button-bar="false" datepicker-options="dateOptions" />
                <span class="input-group-btn">
                  <button class="btn btn-default" data-ng-disabled="!initial.publishDate" data-ng-click="action.datepicker.open($event, 'end')"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
          </div>
          <div class="panel-footer text-right">
            <a class="btn btn-sm btn-default" href="/admin/article" target="_self">取消</a>
            <button type="submit" class="btn btn-sm btn-primary" data-ng-disabled="initial.submit">送出</button>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-md-4 col-sm-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <label>圖片</label>
              </div>
              <div class="panel-body">
                <a class="upload" href="#" data-ng-click="action.fileUpLoad()">
                  <i class="fa fa-upload fa-5x fa-fw" data-ng-show="!articleData.img"></i>
                  <div class="img" data-ng-show="articleData.img">
                    <i class="fa fa-refresh fa-5x fa-fw"></i>
                    <img class="img-rounded" data-ng-src="{{initial.preview}}">
                  </div>
                </a>
                <div class="clearImg">
                  <button type="button" class="btn btn-sm btn-flat btn-warning" data-ng-click="action.clearImg()" data-ng-show="articleData.img">清除圖片</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-4 col-sm-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <label for="tag">關連項目</label>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <label for="tag" class="control-label">標籤</label>
                  <select class="form-control" name="tag" id="tag" data-placeholder="選擇標籤" multiple data-ng-model="articleData.tag" data-ng-options="option.id as option.name for option in relationData.tag" chosen="choseOptions">
                    <option value=""></option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="product" class="control-label">產品</label>
                  <select class="form-control" name="product" id="product" data-placeholder="選擇產品" multiple data-ng-model="articleData.product" data-ng-options="option.id as option.title for option in relationData.product" chosen="choseOptions">
                    <option value=""></option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="case" class="control-label">案件</label>
                  <select class="form-control" name="case" id="case" data-placeholder="選擇案件" multiple data-ng-model="articleData.case" data-ng-options="option.id as option.title for option in relationData.case" chosen="choseOptions">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-4 col-sm-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <label>外部連結</label>
              </div>
              <div class="panel-body">
                <ul class="list-group" data-ng-show="articleData.link.length">
                  <li class="list-group-item" data-ng-repeat="link in articleData.link">
                    <button type="button" class="close" data-ng-click="action.linkAction.remove($index)">×</button>
                    <a href="{{link.url}}" target="_blink"><small data-ng-bind="link.text"></small></a>
                  </li>
                </ul>
                <div class="form-group">
                  <input type="text" id="link-href" class="form-control input-sm" placeholder="連結 (請加http://)" data-ng-model="initial.link.url">
                </div>
                <div class="form-group">
                  <input type="text" id="link-text" class="form-control input-sm" placeholder="顯示文字" data-ng-model="initial.link.text">
                </div>
                <div class="form-group text-right">
                  <button type="button" class="btn btn-sm btn-default" data-ng-click="action.linkAction.add()">新增</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?= js_tag("app/backend/controllers/article-form.js") ?>
<?= js_tag("app/backend/controllers/fileManage/defaultFileManage.js") ?>
<?= js_tag("plugin/ngFileUpload/angular-file-upload.js") ?>
<?= js_tag("plugin/masonry/angular-masonry.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>
<?= js_tag("plugin/tinymce/ng-tinymce.js") ?>
<?= js_tag("plugin/tinymce/tinymce.min.js") ?>