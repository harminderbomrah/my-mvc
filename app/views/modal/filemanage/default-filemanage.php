<div class="modal-content default" data-ng-controller="fileManage" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <div class="modal-header">
    <h4 class="modal-title">File Manage</h4>
    <ul class="modal-tab nav">
      <li data-ng-click="initial.tabSelect = 'folder'" data-ng-class="{'active': initial.tabSelect == 'folder'}"><i class="fa fa-folder-open"></i></li>
      <li data-ng-click="initial.tabSelect = 'upload'" data-ng-class="{'active': initial.tabSelect == 'upload'}"><i class="fa fa-upload"></i></li>
    </ul>
    <div class="modal-search">
      <input type="search" class="form-control input-sm" data-ng-model="fileName" data-ng-keyup="" results="5" placeholder="Search File">
    </div>
  </div>
  <div class="modal-body" data-ng-switch on="initial.tabSelect" resizable>
    <div class="upload animate-switch" data-ng-switch-when="upload" data-ng-file-drop>
      <div class="row">
        <div class="col-md-3">
          <label for="fileupload" class="drop-zone" data-ng-file-over="drop-over">
            <div class="well well-lg text-center" data-ng-show="uploader.isHTML5">
              <i class="fa fa-5x fa-inbox text-muted" data-ng-file-over="text-primary"></i>
            </div>
            <input id="fileupload" type="file" data-ng-file-select multiple  />
          </label>
        </div>
        <div class="col-md-9">
          <div class="upload-control">
            <div class="progress" data-ng-class="{'progress-striped active': uploader.getNotUploadedItems().length}">
              <div class="progress-bar" role="progressbar" data-ng-style="{'width': uploader.progress + '%'}">{{uploader.progress}} %</div>
            </div>
            <button type="button" class="btn btn-success btn-sm" data-ng-click="uploader.uploadAll()" data-ng-disabled="!uploader.getNotUploadedItems().length">
              <span class="fa fa-lg fa-arrow-circle-o-up"></span> Upload all
            </button>
            <button type="button" class="btn btn-warning btn-sm" data-ng-click="uploader.cancelAll()" data-ng-disabled="!uploader.isUploading">
              <span class="fa fa-lg fa-ban"></span> Cancel all
            </button>
            <button type="button" class="btn btn-danger btn-sm" data-ng-click="uploader.clearQueue()" data-ng-disabled="!uploader.queue.length">
              <span class="fa fa-lg fa-trash-o"></span> Remove all
            </button>
          </div>
        </div>
      </div>
      <div class="file-list">
        <ul class="file-list-header list-unstyled clearfix">
          <li>Thumb</li>
          <li>Name</li>
          <li class="text-center" data-ng-show="uploader.isHTML5">Size</li>
          <li data-ng-show="uploader.isHTML5">Progress</li>
          <li class="text-center">Status</li>
          <li>Actions</li>
        </ul>
        <ul class="file-list-body list-unstyled">
          <li class="file-list-item clearfix" data-ng-repeat="item in uploader.queue">
            <div>
              <div data-ng-show="uploader.isHTML5" data-ng-thumb="{file: item.file, height: 50}"></div>
            </div>
            <div>
              <strong data-ng-bind="item.file.name"></strong>
            </div>
            <div class="text-center" data-ng-show="uploader.isHTML5" nowrap>{{item.file.size/1024/1024|number:2}} MB</div>
            <div data-ng-show="uploader.isHTML5">
              <div class="progress" data-ng-class="{'progress-striped active': !item.isSuccess}">
                <div class="progress-bar progress-bar-info" role="progressbar" data-ng-style="{'width': item.progress + '%'}">{{item.progress}} %</div>
              </div>
            </div>
            <div class="text-center">
              <span data-ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
              <span data-ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
              <span data-ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
            </div>
            <div nowrap>
              <button type="button" class="btn btn-success btn-sm" data-ng-click="item.upload()" data-ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                <span class="fa fa-lg fa-arrow-circle-o-up"></span>
              </button>
              <button type="button" class="btn btn-warning btn-sm" data-ng-click="item.cancel()" data-ng-disabled="!item.isUploading">
                <span class="fa fa-lg fa-ban"></span>
              </button>
              <button type="button" class="btn btn-danger btn-sm" data-ng-click="item.remove()">
                <span class="fa fa-lg fa-trash-o"></span>
              </button>
            </div>
          </li>
        </ul>
        <small class="file-list-queue text-right" data-ng-bind="'Queue length: '+uploader.queue.length"></small>
      </div>
    </div>
    <div class="folder animate-switch" data-ng-switch-when="folder">
      <div class="file-group">
        <div masonry masonry-options="{{masonryOptions}}">
          <div masonry-brick class="file-content {{style}}" ng-repeat="file in filejson.file" data-ng-class="{'active': file.checked, 'use': file.use}">
            <img class="file-thumbnail" data-ng-src="{{file.source.small}}" data-ng-click="action.source(file, $index)" alt="{{file.name}}" check-thumbnail>
            <p class="file-name">
              <i class="fa fa-trash-o fa-fw" data-ng-click="action.delete(file.id)"></i>
              <span data-ng-bind="file.name"></span>
            </p>
          </div>
        </div>
      </div>
      <div class="preview" data-ng-if="!initial.multiple">
        <div class="preview-inner">
          <div class="preview-content">
            <img class="img-thumbnail" data-ng-show="fileData.source" data-ng-src="{{fileData.source}}">
            <i class="fa fa-picture-o fa-5x" data-ng-show="!fileData.source"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-sm btn-flat btn-primary" data-ng-click="insert()" data-ng-show="initial.tabSelect == 'folder'" data-ng-disabled="!fileData.source">Insert</button>
    <button type="button" class="btn btn-sm btn-flat btn-default" data-ng-click="cancel()">Cancel</button>
  </div>
</div>