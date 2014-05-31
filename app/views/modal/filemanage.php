<?= content_css_tag("nyfm/unit/file-manage.scss") ?>
<div class="modal-content" data-ng-controller="fileManage" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <div class="modal-header">
    <h4 class="modal-title">File Manage</h4>
    <ul class="modal-tab nav">
      <li><i class="fa fa-upload"></i></li>
      <li><i class="fa fa-folder-open"></i></li>
    </ul>
    <div class="modal-search">
      <input type="search" class="form-control input-sm" data-ng-model="fileName" data-ng-keyup="" results="5" placeholder="Search File">
    </div>
  </div>
  <div class="modal-body">
    <div class="upload"></div>
    <div class="folder">
      <div class="file-bundle col-xs-6 col-sm-4 col-md-3 col-lg-2" data-ng-repeat="file in initial.file">
        <div class="file-content" style="background-image: url({{initial.location + file.class + '/' + file.name + '.' + file.type}})"></div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-sm btn-flat btn-primary" data-ng-click="insert()">Insert</button>
    <button type="button" class="btn btn-sm btn-flat btn-default" data-ng-click="cancel()">Cancel</button>
  </div>
</div>
<script>
  $('.modal-content').removeAttr('data-ng-init');
</script>