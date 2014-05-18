<div class="page-content-top-bar container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <ol class="breadcrumb">
        <li><i class="fa fa-tachometer"></i><a href="/admin" target="_self"> Dashboard</a></li>
        <li data-ng-repeat="b in locationPath" data-ng-class="{active: $last}">
          <a href="/admin/{{b}}" data-ng-if="!$last" target="_self">
            <span>{{b | capitalize}}</span>
          </a>
          <span data-ng-if="$last">{{b | capitalize}}</span>
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