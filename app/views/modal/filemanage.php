<?= content_css_tag("nyfm/unit/file-manage.scss") ?>
<div class="modal-content" data-ng-controller="fileManage" data-ng-init='extend(<?= json_encode($initial) ?>)'>
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
    <div class="upload animate-switch" data-ng-switch-when="upload" ng-file-drop>
      <div class="queue"></div>
      <div class="drop-zone">
        <label for="file-select" ng-file-over="other-over-zone" class="over-zone zone">
          Base drop zone indication
          <input type="file" id="file-select" ng-file-select multiple />
        </label>
      </div>
    </div>
    <div class="folder animate-switch" data-ng-switch-when="folder">
      <div class="file-group">
        <table>
          <tbody>
            <tr class="file-bundle" data-ng-repeat="files in fileGroup">
              <td class="file-content" data-ng-repeat="file in files">
                <a data-ng-href="{{action.source(file)}}" target="_blink">
                  <img data-ng-src="{{action.thumbnail(file, 'small')}}" alt="{{file.name}}">
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="preview">
        <div class="preview-inner">
          <div class="preview-content">
            <img src="/public/file/image/s_stone24.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-sm btn-flat btn-primary" data-ng-click="insert()" data-ng-show="initial.tabSelect == 'folder'">Insert</button>
    <button type="button" class="btn btn-sm btn-flat btn-default" data-ng-click="cancel()">Cancel</button>
  </div>
</div>
<script>
  $('.modal-content').removeAttr('data-ng-init');
</script>