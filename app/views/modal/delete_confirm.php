<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-ng-click="cancel()" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Delete select</h4>
  </div>
  <div class="modal-body lead text-center">
    {{msg}}
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-sm btn-flat btn-default pull-left" data-ng-click="cancel()">Close</button>
    <button type="button" class="btn btn-sm btn-flat btn-danger" data-ng-click="delete()">Delete</button>
  </div>
</div>