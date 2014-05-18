<?= content_css_tag("nyfm/unit/category-lsit.scss") ?>
<?= content_css_tag("plugin/chosen.scss") ?>
<div class="main-category" data-ng-controller="caseCategory" data-ng-init='category = <?= json_encode($category) ?>'>
  <div class="btn-toolbar" role="toolbar">
    <div class="input-group input-group-sm created-new">
      <input type="text" class="form-control" data-ng-model="newCategory" data-ng-keyup="action.new(newCategory, $event)" data-ng-disabled="initial.buffer" results="5" placeholder="what category to be created">
      <span class="input-group-btn">
        <button class="btn btn-primary" type="button" data-ng-click="action.new(newCategory, $event)" data-ng-disabled="initial.buffer">
          <i class="fa fa-fw fa-plus" data-ng-class="{'fa-spinner fa-spin': initial.buffer}"></i>
        </button>
      </span>
    </div>
    <div class="btn-group pull-right">
      <input type="search" class="form-control input-sm" data-ng-model="keyWrod" data-ng-keyup="action.clearModelWhenEscape($event,'keyWrod')" results="5" placeholder="Search Title">
    </div>
  </div>
  <ul class="category-list">
    <li class="list-item" data-ng-repeat="item in categorys = (category | filter: {'name':keyWrod})" data-ng-class="{'editing': item.edited}">
      <span class="view">
        <label data-ng-dblclick="action.edit(item.name, $index, $event)">{{item.name}}</label>
        <span class="badge badge-primary">{{item.quantity}}</span>
        <span class="fa fa-fw fa-times pull-right" data-ng-click="action.remove(item, $index)" data-ng-if="category.length > 1"></span>
        <span class="fa fa-fw fa-pencil pull-right" data-ng-click="action.edit(item.name, $index, $event)"></span>
      </span>
      <input type="text" class="edit form-control" data-ng-trim="false" data-ng-model="item.name" data-ng-blur="action.doneEditing(item.name, $index)" data-ng-keyup="action.doneEditingWithKey($event, item.name, $index)">
    </li>
  </ul>
</div>
<script type="text/ng-template" id="confirmModal.html">
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
</script>
<?= js_tag("app/backend/controllers/case.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>