<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-ng-click="cancel()" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Delete select</h4>
  </div>
  <div class="modal-body">
    <p class="lead text-center">{{config.msg}}</p>
    <div class="form-group" data-ng-class="{'has-error': config.error}" ng-if="config.replace">
      <label class="control-label" ng-if="config.error">You must select a category</label>
      <select class="form-control" data-placeholder="Choose Category" ng-model="config.category" ng-options="option.id as option.name for option in config.categorys" chosen>
        <option value=""></option>
      </select>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-sm btn-flat btn-danger pull-left" data-ng-click="delete()">Delete</button>
    <button type="button" class="btn btn-sm btn-flat btn-default" data-ng-click="cancel()">Close</button>
  </div>
</div>