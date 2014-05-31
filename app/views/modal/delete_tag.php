<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-ng-click="cancel()" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Delete select</h4>
  </div>
  <div class="modal-body">
    <p class="lead text-center">{{config.msg}}</p>
    <div class="form-group" data-ng-class="{'has-error': config.error}" ng-if="config.replace">
      <label class="control-label" ng-if="config.error">You must select a tag</label>
      <select class="form-control" data-placeholder="Choose tag" ng-model="config.tag" ng-options="option.id as option.name for option in config.tags" chosen>
        <option value=""></option>
      </select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-sm btn-flat btn-danger pull-left" data-ng-click="delete()">Delete</button>
    <button type="button" class="btn btn-sm btn-flat btn-default" data-ng-click="cancel()">Close</button>
  </div>
</div>