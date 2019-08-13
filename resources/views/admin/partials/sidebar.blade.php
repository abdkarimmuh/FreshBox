<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}"><img src="{{asset('assets/img/logo-freshbox.png')}}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('admin.dashboard') }}"><img src="{{asset('assets/img/icon-freshbox.png')}}" width="40px"
                                                      height="40px"></a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="{{ Request::route()->getName() == 'admin.dashboard' ? ' active' : '' }}"><a class="nav-link"
                                                                                               href="{{ route('admin.dashboard') }}"><i
                    class="fa fa-columns"></i> <span>Dashboard</span></a></li>
        <li class=""><a class="nav-link"
                        href="{{ route('admin.dashboard') }}"><i
                    class="fa fa-columns"></i> <span>Test</span></a></li>

        @if(Auth::user()->can('manage-users'))
            <li class="menu-header">Users</li>
            <li class="{{ Request::route()->getName() == 'admin.users' ? ' active' : '' }}"><a class="nav-link"
                                                                                               href="{{ route('admin.users') }}"><i
                        class="fa fa-users"></i> <span>Users</span></a></li>
        @endif
    </ul>
</aside>
