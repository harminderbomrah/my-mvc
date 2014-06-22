<div class="page-content-top-bar container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <ol class="breadcrumb">
        <li><i class="fa fa-tachometer"></i><a href="/admin" target="_self"> Dashboard</a></li>
        <li data-ng-repeat="breadcrumbs in locationPath" data-ng-class="{active: $last}">
          <a href="/admin/{{breadcrumbs}}" data-ng-show="!$last" target="_self">
            <span data-ng-bind="breadcrumbs | capitalize"></span>
          </a>
          <span data-ng-show="$last" data-ng-bind="breadcrumbs | capitalize"></span>
        </li>
      </ol>
    </div>
    <!-- <div class="col-xs-3">
      <div class="page-content-top-search">
        <form>
          <input type="search" results="5" placeholder="Seach">
        </form>
      </div>
    </div> -->
  </div>
</div>