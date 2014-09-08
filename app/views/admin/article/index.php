<?= content_css_tag("plugin/chosen.scss") ?>
<?= content_css_tag("backsite/unit/main-list.scss") ?>
<div class="main-list" data-ng-controller="articleList" data-ng-init='extend(<?= json_encode($initial) ?>)'>
  <div class="table-action btn-toolbar" role="toolbar">
    <div class="btn-group" data-ng-show="initial.selection.length">
      <button type="button" class="btn btn-sm btn-orange" data-ng-click="action.modal(false, '您確定真的要刪除文章？')">
        <i class="fa fa-trash-o fa-fw"></i>
      </button>
    </div>
    <div class="btn-group" data-ng-show="initial.selection.length && initial.trash">
      <button type="button" class="btn btn-sm btn-info" data-ng-click="action.modal(true)">
        <i class="fa fa-undo fa-fw"></i>
      </button>
    </div>
    <div class="btn-group">
      <a href="new" class="btn btn-sm btn-primary" target="_self"><i class="fa fa-fw fa-plus"></i> 新增</a>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-default" data-ng-model="initial.publics" data-ng-click="initial.trash = false; action.deselect()" btn-radio="false">已發佈文章</button>
      <button type="button" class="btn btn-sm btn-default" data-ng-model="initial.publics" data-ng-click="initial.trash = false; action.deselect()" btn-radio="true">隱藏文章</button>
      <button type="button" class="btn btn-sm btn-default" data-ng-model="initial.trash" data-ng-click="initial.publics = undefined; action.deselect()" btn-radio="true">回收桶</button>
    </div>
    <div class="btn-group">
      <select class="form-control" data-placeholder="選擇類別" data-ng-model="initial.category" data-ng-options="option.id as option.name for option in initial.categorys" chosen="initial.choseOptions">
        <option value=""></option>
      </select>
    </div>
    <div class="btn-group pull-right">
      <input type="search" class="form-control input-sm" data-ng-model="keyWrod" data-ng-keyup="action.clearModelWhenEscape($event,'keyWrod')" results="5" placeholder="搜尋文章標題">
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
        <th class="list-date" data-ng-click="action.sorting('publishDate')" data-ng-class="{hit:initial.orderName == 'publishDate'}">日期 <i class="fa" data-ng-show="initial.orderName == 'publishDate'" data-ng-class="{'fa-caret-down': initial.reverse == true, 'fa-caret-up': initial.reverse == false,}"></i></th>
        <th class="list-title" data-ng-click="action.sorting('title')" data-ng-class="{hit:initial.orderName == 'title'}">標題 <i class="fa" data-ng-show="initial.orderName == 'title'" data-ng-class="{'fa-caret-down': initial.reverse == false, 'fa-caret-up': initial.reverse == true,}"></i></th>
        <th class="text-center" data-ng-bind="filterList.length"></th>
      </tr>
    </thead>
    <tbody>
      <tr data-ng-show="!newList.length">
        <td colspan="5" class="text-center"><strong>沒有文章</strong></td>
      </tr>
      <tr data-ng-repeat="list in newList = (filterList = (articleList | filter: {'title':keyWrod} | filter: {'disabled':initial.publics} | filter: {'trash':initial.trash} | filter: {'category':initial.category}) | orderBy: initial.orderName : initial.reverse | startFrom: (initial.currentPage - 1) * initial.pageSize : initial.pageSize + ((initial.currentPage - 1) * initial.pageSize))" data-ng-class="{'active': list.checked, 'disabled': list.disabled}" data-ng-show="newList.length">
        <td>
          <label class="checked">
            <i class="fa fa-square-o"></i>
            <input type="checkbox" name="list_id" value="{{list.id}}" data-ng-model="list.checked" data-ng-change="action.checkSelected($index)">
          </label>
        </td>
        <td data-ng-bind="list.publishDate | date:'yyyy/MM/dd'"></td>
        <td><a data-ng-bind="list.title" href="/blog/{{list.id}}" target="_blank"></a></td>
        <td class="text-center"><a class="btn btn-default btn-xs" href="edit/{{list.id}}" target="_self"><i class="fa fa-edit"></i></a></td>
        <!-- <td class="text-center">
          <label class="switch">
            <input type="checkbox" data-ng-model="list.disabled" data-ng-change="action.disabledItem(list.disabled, list.id, $index)" class="switch-input">
            <span class="switch-label"></span>
            <span class="switch-handle"></span>
          </label>
        </td> -->
      </tr>
    </tbody>
  </table>
  <div class="text-center" data-ng-show="filterList.length >= initial.pageSize">
    <pagination total-items="filterList.length" items-per-page="initial.pageSize" data-ng-model="initial.currentPage" max-size="initial.maxSize" class="pagination-sm" boundary-links="true"></pagination>
  </div>
  <alert class="text-center fade" data-ng-repeat="alert in initial.alerts" data-ng-bind="alert.msg" type="alert.type" close="action.alerts.close()"></alert>
</div>
<?= js_tag("app/backend/controllers/article-list.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>