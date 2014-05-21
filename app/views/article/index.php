<?= content_css_tag("plugin/chosen.scss") ?>
<?= content_css_tag("nyfm/unit/main-list.scss") ?>
<div class="main-list" data-ng-controller="articleList" data-ng-init='extend(<?= json_encode($initial) ?>)'>
	<div class="table-action btn-toolbar" role="toolbar">
    <div class="btn-group" data-ng-if="initial.selection.length">
      <button type="button" class="btn btn-sm btn-orange" data-ng-click="action.modal(false, 'Are you sure you want to delete?')">
        <i class="fa fa-trash-o fa-fw"></i>
      </button>
    </div>
    <div class="btn-group" data-ng-if="initial.selection.length && initial.trash">
      <button type="button" class="btn btn-sm btn-info" data-ng-click="action.modal(true)">
        <i class="fa fa-undo fa-fw"></i>
      </button>
    </div>
    <div class="btn-group">
      <a href="new" class="btn btn-sm btn-primary" target="_self"><i class="fa fa-fw fa-plus"></i> New</a>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-default" data-ng-model="initial.publics" data-ng-click="initial.trash = false; action.deselect()" btn-radio="false">Public</button>
      <button type="button" class="btn btn-sm btn-default" data-ng-model="initial.publics" data-ng-click="initial.trash = false; action.deselect()" btn-radio="true">Private</button>
      <button type="button" class="btn btn-sm btn-default" data-ng-model="initial.trash" data-ng-click="initial.publics = undefined; action.deselect()" btn-radio="true">Trash</button>
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
				<th class="list-date" ng-click="action.sorting('date')" data-ng-class="{hit:initial.orderName == 'date'}">Date <i class="fa" data-ng-if="initial.orderName == 'date'" data-ng-class="{'fa-caret-down': initial.reverse == true, 'fa-caret-up': initial.reverse == false,}"></i></th>
				<th class="list-title" ng-click="action.sorting('title')" data-ng-class="{hit:initial.orderName == 'title'}">Title <i class="fa" data-ng-if="initial.orderName == 'title'" data-ng-class="{'fa-caret-down': initial.reverse == false, 'fa-caret-up': initial.reverse == true,}"></i></th>
        <th class="text-center">{{filterList.length}}</th>
			</tr>
		</thead>
		<tbody>
			<tr data-ng-if="!newList.length">
				<td colspan="5" class="text-center"><strong>No Article</strong></td>
			</tr>
			<tr data-ng-repeat="list in newList = (filterList = (articleList | filter: {'title':keyWrod} | filter: {'disabled':initial.publics} | filter: {'trash':initial.trash} | filter: {'category':initial.category}) | orderBy: initial.orderName : initial.reverse | startFrom: (initial.currentPage - 1) * initial.pageSize : initial.pageSize + ((initial.currentPage - 1) * initial.pageSize))" data-ng-class="{'active': list.checked, 'disabled': list.disabled}" data-ng-if="newList.length">
				<td>
					<label class="checked">
						<i class="fa fa-square-o"></i>
						<input type="checkbox" name="list_id" value="{{list.id}}" data-ng-model="list.checked" data-ng-change="action.checkSelected($index)">
					</label>
				</td>
				<td>{{list.date | date:'yyyy/MM/dd'}}</td>
				<td><a href="?id={{list.id}}" target="_blink">{{list.title}}</a></td>
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
	<div class="text-center" data-ng-if="articleList.length >= initial.pageSize">
		<pagination total-items="filterList.length" items-per-page="initial.pageSize" page="initial.currentPage" max-size="initial.maxSize" class="pagination-sm" boundary-links="true"></pagination>
  </div>
  <alert class="text-center fade" data-ng-repeat="alert in initial.alerts" type="alert.type" close="action.alerts.close()">{{alert.msg}}</alert>
</div>

<script type="text/ng-template" id="confirmModal.html">
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
</script>
<?= js_tag("app/backend/controllers/article.js") ?>
<?= js_tag("plugin/chosen/chosen.jquery.js") ?>