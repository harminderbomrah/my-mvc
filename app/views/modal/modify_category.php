<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-ng-click="cancel()" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Create</h4>
  </div>
  <div class="modal-body form-horizontal">
    <div class="form-group" data-ng-class="{'has-error': error || length}">
      <label for="Name" class="col-sm-2 control-label">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="Name" data-ng-model="data.name" data-ng-blur="checkValue(data.name)" placeholder="Category Name">
        <span class="help-block" data-ng-show="error || length" data-ng-bind="msg"></span>
      </div>
    </div>
    <div class="form-group">
      <label for="description" class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10">
        <textarea class="form-control" id="description" data-ng-model="data.description" rows="3"></textarea>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-sm btn-flat btn-default" data-ng-click="cancel()">Close</button>
    <button type="button" class="btn btn-sm btn-flat btn-primary" data-ng-click="create()" data-ng-bind="buttonText"></button>
  </div>
</div>