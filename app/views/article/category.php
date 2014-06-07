<?= content_css_tag("nyfm/unit/category-lsit.scss") ?>
<?= content_css_tag("plugin/chosen.scss") ?>
<div class="main-category" data-ng-controller="articleCategory" data-ng-init='category = <?= json_encode($category) ?>'>
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
        <span class="fa fa-fw fa-times pull-right" data-ng-click="action.remove(item, $index)" data-ng-show="category.length > 1"></span>
        <span class="fa fa-fw fa-pencil pull-right" data-ng-click="action.edit(item.name, $index, $event)"></span>
      </span>
      <input type="text" class="edit form-control" data-ng-trim="false" data-ng-model="item.name" data-ng-blur="action.doneEditing(item.name, $index)" data-ng-keyup="action.doneEditingWithKey($event, item.name, $index)">
    </li>
  </ul>
</div>
<?= js_tag("app/backend/controllers/article-category.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>