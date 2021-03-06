<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>BVMS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>BVMS</b>ystem</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ url('/') . Session::get('userSession')['user_photo'] }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Session::get('userSession')['fname'] . ' ' . Session::get('userSession')['lname'] }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ url('/') . Session::get('userSession')['user_photo'] }}" class="img-circle" alt="User Image">

                <p>
                  {{ Session::get('userSession')['fname'] . ' ' . Session::get('userSession')['lname'] }} - Brgy. Tanod
                  <small>Username: {{ Session::get('userSession')['account_uname'] }}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/users/update" class="btn btn-default btn-flat">Update Profile</a>
                </div>
                <div class="pull-right">
                  <a href="/clear" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>        </ul>
      </div>
    </nav>
  </header>