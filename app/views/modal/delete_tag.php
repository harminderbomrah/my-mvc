<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-ng-click="cancel()" aria-hidden="true">&times;</button>
    <h4 class="modal-title">刪除選取</h4>
  </div>
  <div class="modal-body">
    <p class="lead text-center">{{config.msg}}</p>
    <div class="form-group" data-ng-class="{'has-error': config.error}" ng-if="config.replace">
      <label class="control-label" ng-if="config.error">你必選選擇一個標籤作為取代</label>
      <select class="form-control" data-placeholder="選擇標籤" ng-model="config.tag" ng-options="option.id as option.name for option in config.tags" chosen>
        <option value=""></option>
      </select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-sm btn-flat btn-danger pull-left" data-ng-click="delete()">刪除</button>
    <button type="button" class="btn btn-sm btn-flat btn-default" data-ng-click="cancel()">取消</button>
  </div>
</div>