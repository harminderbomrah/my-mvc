<?= content_css_tag("plugin/chosen.scss") ?>
<?= content_css_tag("nyfm/unit/form.scss") ?>
<div class="main-form" data-ng-controller="caseForm" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <form class="form-horizontal" data-ng-submit="action.submit()" role="form">
    <div class="row">
      <div class="col-lg-9">
        <div class="form-group" data-ng-class="{'has-error': initial.error.title}">
          <input type="text" class="form-control input-lg" name="title" id="title" placeholder="Title" data-ng-blur="action.clearError($event)" data-ng-model="caseData.title">
        </div>
        <div class="form-group">
          <textarea class="form-control" name="content" id="content" data-ng-model="caseData.content" ui-tinymce="tinyMceOptions"></textarea>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Category</label>
          </div>
          <div class="panel-body">
            <div class="form-group" data-ng-class="{'has-error': initial.error.category}">
              <select class="form-control" name="category" id="category" data-placeholder="Choose Category" data-ng-model="caseData.category" data-ng-options="option.id as option.name for option in relationData.categorys" data-ng-change="action.change('category')" chosen="choseOptions">
                <option value=""></option>
              </select>
            </div>
            <div class="form-group">
              <a href="" data-ng-click="action.toggleBtn()"><small>{{initial.toggleVel.srt}}</small></a>
              <input type="text" class="form-control input-sm" data-ng-model="caseData.category" data-ng-if="initial.toggleVel.bl">
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Status</label>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label for="disabled" class="control-label">Publish</label>
              <div class="switch reverse">
                <input type="checkbox" name="disabled" id="disabled" class="switch-input" data-ng-model="caseData.disabled">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="publishDate" class="control-label">Publish date</label>
              <div class="switch">
                <input type="checkbox" name="publishDate" id="publishDate" class="switch-input" data-ng-model="initial.publishDate" data-ng-click="action.datepicker.clear(initial.publishDate)">
                <span class="switch-label"></span>
                <span class="switch-handle"></span>
              </div>
              <div class="input-group" data-ng-class="{'hide': !initial.publishDate}">
                <input type="text" class="form-control" data-ng-model="caseData.date" is-open="opened" min="initial.today" datepicker-popup="yyyy/MM/dd" show-button-bar="false" datepicker-options="dateOptions" />
                <span class="input-group-btn">
                  <button class="btn btn-default" data-ng-click="action.datepicker.open($event)"><i class="fa fa-calendar"></i></button>
                </span>
              </div>
            </div>
          </div>
          <div class="panel-footer text-right">
            <a class="btn btn-sm btn-default" href="/admin/case" target="_self">Cancel</a>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Images</label>
          </div>
          <div class="panel-body">
            <a class="upload" href="#" data-ng-click="action.fileUpLoad()">
              <i class="fa fa-upload fa-5x fa-fw" data-ng-if="!caseData.img"></i>
              <div class="img" data-ng-if="caseData.img">
                <i class="fa fa-refresh fa-5x fa-fw"></i>
                <img class="img-rounded" data-ng-src="{{caseData.img}}">
              </div>
            </a>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <label for="tag">Relation</label>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label for="tag" class="control-label">Tag</label>
              <select class="form-control" name="tag" id="tag" data-placeholder="Choose Tag" multiple data-ng-model="caseData.tag" data-ng-options="option.id as option.name for option in relationData.tag" chosen="choseOptions">
                <option value=""></option>
              </select>
            </div>
            <div class="form-group">
              <label for="product" class="control-label">Product</label>
              <select class="form-control" name="product" id="product" data-placeholder="Choose Product" multiple data-ng-model="caseData.product" data-ng-options="option.id as option.title for option in relationData.product" chosen="choseOptions">
                <option value=""></option>
              </select>
            </div>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">
            <label>Link</label>
          </div>
          <div class="panel-body">
            <ul class="list-group" data-ng-if="caseData.link.length">
              <li class="list-group-item" data-ng-repeat="link in caseData.link">
                <button type="button" class="close" data-ng-click="action.linkAction.remove($index)">×</button>
                <a href="{{link.url}}" target="_blink"><small>{{link.text}}</small></a>
              </li>
            </ul>
            <div class="form-group">
              <input type="text" id="link-href" class="form-control input-sm" placeholder="URL" data-ng-model="initial.link.url">
            </div>
            <div class="form-group">
              <input type="text" id="link-text" class="form-control input-sm" placeholder="Text" data-ng-model="initial.link.text">
            </div>
            <div class="form-group text-right">
              <button type="button" class="btn btn-sm btn-default" data-ng-click="action.linkAction.add()">Add</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?= js_tag("app/backend/controllers/case-form.js") ?>
<?= js_tag("app/backend/controllers/fileManage.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>
<?= js_tag("plugin/tinymce/ng-tinymce.js") ?>
<?= js_tag("plugin/tinymce/tinymce.min.js") ?>