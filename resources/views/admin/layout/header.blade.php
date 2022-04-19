<header class="main-header">  
    <nav class="navbar blue-bg navbar-static-top"> 
        <ul class="nav navbar-nav pull-left">
            <li><a class="sidebar-toggle" data-toggle="push-menu" href=""></a> </li>
        </ul>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav"> 
                <li class="dropdown user user-menu p-ph-res"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">  <span class="hidden-xs">Admin</span> <img src="{{asset('assets/admin/images/user.png')}}" class="user-image" alt="User Image"></a>
                    <ul class="dropdown-menu">
                    @if(Session::get('admin_logged_in')['type']=='0')
                    <li><a href="{{url('admin/edit_profile')}}"><i class="fa fa-user"></i> Edit Profile</a></li> 
                    @endif
                     <li><a href="{{url('admin/change_password')}}"><i class="fa fa-lock"></i>Change Password</a></li>  
                        <li><a href="#exampleModal-out" data-direction="finish" data-toggle="modal"><i class="fa fa-sign-out"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav"> 
                <!-- <li class="dropdown user user-menu p-ph-res" style="position: relative; margin-top: 16px;"> <i class="fa fa-user" aria-hidden="true"></i> Last Login -->
                <!-- <ul>
                  <span style="position: relative; right: 40px;">{{date('d M Y H:m:i', strtotime(Session::get('last_log_in')['last_login']))}}</span>
                    </ul> -->
                </li>
            </ul>
        </div>
    </nav>
</header>
