<?= content_css_tag("plugin/chosen.scss") ?>
<?= content_css_tag("nyfm/unit/main-list.scss") ?>
<div class="main-list" data-ng-controller="productList" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <div class="table-action btn-toolbar" role="toolbar">
    <div class="btn-group" data-ng-show="initial.selection.length">
      <button type="button" class="btn btn-sm btn-orange" data-ng-click="action.modal(false, 'Are you sure you want to delete?')">
        <i class="fa fa-trash-o fa-fw"></i>
      </button>
    </div>
    <div class="btn-group" data-ng-show="initial.selection.length && initial.trash">
      <button type="button" class="btn btn-sm btn-info" data-ng-click="action.modal(true)">
        <i class="fa fa-undo fa-fw"></i>
      </button>
    </div>
    <div class="btn-group">
      <a href="new" class="btn btn-sm btn-primary" target="_self"><i class="fa fa-fw fa-plus"></i> New</a>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-default" data-ng-model="initial.trash" data-ng-click="action.deselect()" btn-checkbox btn-checkbox-true="1" btn-checkbox-false="0">Trash</button>
    </div>
    <div class="btn-group">
      <select class="form-control" data-placeholder="Choose Category" data-ng-model="initial.category" data-ng-options="option.id as option.name for option in initial.categorys" chosen="initial.choseOptions">
        <option value=""></option>
      </select>
    </div>
    <div class="btn-group pull-right">
      <input type="search" class="form-control input-sm" data-ng-model="keyWrod" data-ng-keyup="action.clearModelWhenEscape($event,'keyWrod')" results="5" placeholder="Search Title">
    </div>
  </div>
  <table class="table table-striped table-hover table-responsive">
    <thead>
      <tr>
        <th class="list-check">
          <label class="checked">
            <i class="fa" data-ng-class="{'fa-minus-square-o': initial.checkedEach == 2, 'fa-check-square-o': initial.checkedEach == 1, 'fa-square-o': initial.checkedEach == 0}"></i>
            <input type="checkbox" data-ng-model="initial.allChecked" data-ng-change="action.checkAll(newList)">
          </label>
        </th>
        <th class="list-title" ng-click="action.sorting('name')" data-ng-class="{hit:initial.orderName == 'name'}">Name <i class="fa" data-ng-show="initial.orderName == 'name'" data-ng-class="{'fa-caret-down': initial.reverse == false, 'fa-caret-up': initial.reverse == true,}"></i></th>
        <th class="text-center">{{filterList.length}}</th>
      </tr>
    </thead>
    <tbody>
      <tr data-ng-show="!newList.length">
        <td colspan="5" class="text-center"><strong>No Article</strong></td>
      </tr>
      <tr data-ng-repeat="list in newList = (filterList = (productList | filter: {'name':keyWrod} | filter: {'trash':initial.trash} | filter: {'category':initial.category}) | orderBy: initial.orderName : initial.reverse | startFrom: (initial.currentPage - 1) * initial.pageSize : initial.pageSize + ((initial.currentPage - 1) * initial.pageSize))" data-ng-class="{'active': list.checked}" data-ng-show="newList.length">
        <td>
          <label class="checked">
            <i class="fa fa-square-o"></i>
            <input type="checkbox" name="list_id" value="{{list.id}}" data-ng-model="list.checked" data-ng-change="action.checkSelected($index)">
          </label>
        </td>
        <td><a href="/product/{{list.id}}" target="_blink">{{list.name}}</a></td>
        <td class="text-center"><a class="btn btn-default btn-xs" href="edit/{{list.id}}" target="_self"><i class="fa fa-edit"></i></a></td>
      </tr>
    </tbody>
  </table>
  <div class="text-center" data-ng-show="productList.length >= initial.pageSize">
    <pagination total-items="filterList.length" items-per-page="initial.pageSize" page="initial.currentPage" max-size="initial.maxSize" class="pagination-sm" boundary-links="true"></pagination>
  </div>
  <alert class="text-center fade" data-ng-repeat="alert in initial.alerts" type="alert.type" close="action.alerts.close()">{{alert.msg}}</alert>
</div>
<?= js_tag("app/backend/controllers/product-list.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>
<?= js_tag("app/backend/controllers/product.js") ?>