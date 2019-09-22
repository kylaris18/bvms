  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="min-height: 70px">
        <div class="pull-left image">
          <img src="{{ url('/') . Session::get('userSession')['user_photo'] }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info" style="white-space: normal">
          <p>{{ Session::get('userSession')['fname'] . ' ' . Session::get('userSession')['lname'] }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGATION</li>
        <li class="active treeview">
          <a href="{{ url('/') }}/dashboard">
            <i class="fa fa-bar-chart"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="{{ url('/') }}/violations/list">
            <i class="fa fa-eye"></i>
            <span>View Violations</span>
          </a>
        </li>
        <li class="treeview">
          <a href="{{ url('/') }}/violations/add">
            <i class="fa fa-pencil-square-o"></i>
            <span>Add Violations</span>
          </a>
        </li>
        @if (Session::get('userSession')['account_type'] === 0)
        <li class="header">ADMIN PANEL</li>
        <li class="treeview">
          <a href="{{ url('/') }}/users/add">
            <i class="fa fa-user-plus"></i>
            <span>Add Account</span>
          </a>
        </li>
        <li class="treeview">
          <a href="{{ url('/') }}/users/suspend">
            <i class="fa fa-user-times"></i>
            <span>Suspend Account</span>
          </a>
        </li>
        <li class="treeview">
          <a href="{{ url('/') }}/violations/reports">
            <i class="fa fa-file-excel-o"></i>
            <span>Report Logs</span>
          </a>
        </li>
        @endif
        <li class="header">Others</li>
        <li class="treeview">
          <a href="{{ url('/') }}/info">
            <i class="fa fa-map-marker"></i>
            <span>Brgy Info</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>