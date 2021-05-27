
  <header class="main-header">
    <!-- Logo -->
    <a href="#!" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>G</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">LocalFineFoods</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
            </a>
            <ul class="dropdown-menu">
              {{-- <li class="header">You have 4 messages</li> --}}
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
              <?php $notifications = App\Model\Notification::where(["user_id" => 1, 'status' => 'AC'])->get();?>
            @if($notifications)
                    @foreach ($notifications as $notification)
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="{{URL::asset('/images/logo.jpg')}}" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                    @endforeach
                @else
                <li><a href="#">New notification not found</a></li>
                @endif
                  <!-- end message -->
                </ul>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{URL::asset('/images/logo.jpg')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">Admin Panel</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{URL::asset('/images/logo.jpg')}}" class="img-circle" alt="User Image">
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('changePassword')}}" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="{{route('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>