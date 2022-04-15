<aside class="main-sidebar">
    <div class="sidebar">
        <div class="user-panel">
            <div class="image text-center"><img src="{{asset('assets/admin/images/logo.png')}}" alt="logo"> </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
       
            <li class="<?= Request::segment(2) == 'dashboard' || Request::segment(2) == 'dashboard' ? 'active' : ''; ?>"> <a href="{{url('admin/dashboard')}}">  <img src="{{asset('assets/admin/images/sideimg/dashboard.png')}}"  alt="dashboard"> <span>Dashboard</span></a></li>
            <li class="<?= Request::segment(2) == 'user-management' || Request::segment(2) == 'user-detail' ? 'active' : ''; ?>"> <a href="{{url('admin/user-management')}}">  <img src="{{asset('assets/admin/images/sideimg/users.png')}}"  alt="User list"> <span>User Management</span></a></li>
            <li class="<?= Request::segment(2) == 'plate-management' || Request::segment(2) == 'plate-detail' ? 'active' : ''; ?>"> <a href="{{url('admin/plate-management')}}">  <img src="{{asset('assets/admin/images/sideimg/plate.png')}}"  alt="User list"> <span>Plate Management</span></a></li>
           @if(Session::get('admin_logged_in')['type']=='0')
            <li class="<?= Request::segment(2) == 'sub-admin-management' || Request::segment(2) == 'sub-admin' ? 'active' : ''; ?>"> <a href="{{url('admin/sub-admin-management')}}">  <img src="{{asset('assets/admin/images/sideimg/subadmin.png')}}"  alt="event"> <span>Sub Admin Management</span></a></li>
            <li class="<?= Request::segment(2) == 'content-management' || Request::segment(2) == 'content-plan' ? 'active' : ''; ?>"> <a href="{{url('admin/content-management')}}">  <img src="{{asset('assets/admin/images/sideimg/content.png')}}"  alt="content"> <span>Content Management</span></a></li>
        @endif
            <li class="<?= Request::segment(2) == 'query-management' || Request::segment(2) == 'query-detail' ? 'active' : ''; ?>"> <a href="{{url('admin/query-management')}}">  <img src="{{asset('assets/admin/images/sideimg/help.png')}}"  alt="Help & Support"> <span>Help & Support</span></a></li> 

        </ul>
    </div>
</aside>