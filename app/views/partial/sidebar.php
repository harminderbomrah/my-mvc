<nav class="main-sidebar" id="sidebar" data-ng-class="initial.collapse.menu" data-ng-controller="sidebar">
  <div class="sidebar-collapse" data-ng-click="action.collapseSidebar()">
    <i class="fa fa-fw" data-ng-class="'fa-angle-double-' + initial.collapse.arrow"></i>
  </div>
  <ul class="sidebar-nav level-1">
    <li data-ng-repeat="list in sidebarList" data-ng-class="{'active open': list.link == initial.active[0]}">
      <a href="/admin/{{list.link}}" target="_self">
        <i data-ng-class="action.iconType(list.icon)" class="fa-fw"></i>
        <span class="menu-text">{{list.name}}</span>
      </a>
      <b class="arrow" data-ng-show="list.child">
        <i class="fa fa-angle-down"></i>
      </b>
      <ul class="sidebar-nav level-2" data-ng-show="list.child">
        <li data-ng-repeat="subMenu in list.child" data-ng-class="{active: list.link == initial.active[0] && subMenu.link == initial.active[1]}">
          <a href="/admin/{{list.link}}/{{subMenu.link}}" target="_self">
            <span class="sub-menu-text">{{subMenu.name}}</span>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>