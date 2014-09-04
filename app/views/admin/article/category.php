<?= content_css_tag("backsite/unit/category-lsit.scss") ?>
<?= content_css_tag("plugin/chosen.scss") ?>
<div class="main-category" data-ng-controller="articleCategory" data-ng-init='category = <?= json_encode($category) ?>'>
  <div class="btn-toolbar" role="toolbar">
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-primary" data-ng-click="action.modify('new')">
        <i class="fa fa-fw fa-plus"></i> 新增
      </button>
    </div>
    <div class="btn-group pull-right">
      <input type="search" class="form-control input-sm" data-ng-model="keyWrod" data-ng-keyup="action.clearModelWhenEscape($event,'keyWrod')" results="5" placeholder="搜尋類別標題">
    </div>
  </div>
  <ul class="list-group category-list">
    <li class="list-group-item list-item" data-ng-repeat="item in categorys = (category | filter: {'name':keyWrod})">
      <span class="fa fa-fw fa-times pull-right" data-ng-click="action.remove(item, $index)" data-ng-show="category.length > 1"></span>
      <span class="fa fa-fw fa-pencil pull-right" data-ng-click="action.modify('edit', item.name, item.description, $index)"></span>
      <h4 class="list-group-item-heading">
        <span data-ng-bind="item.name"></span>
        <span class="badge badge-primary" data-ng-bind="item.quantity"></span>
      </h4>
      <p class="list-group-item-text" data-ng-bind="item.description"></p>
    </li>
  </ul>
</div>
<?= js_tag("app/backend/controllers/article-category.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>