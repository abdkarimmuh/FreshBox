<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}"><img src="{{asset('assets/img/logo-freshbox.png')}}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{asset('assets/img/icon-freshbox.png')}}" width="32px" height="32px">
        </a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header"></li>
        <li class="menu-header"></li>
        <li class="{{ Request::route()->getName() == 'admin.dashboard' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home"></i><span>Dashboard</span></a>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'marketing' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-bullhorn"></i><span>Marketing</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->route()->getName() == 'admin.marketing.form_sales_order' ? ' active' : '' }}">
                    <a href="{{ route('admin.marketing.form_sales_order') }}" class="nav-link"><span>Form Sales Order</span></a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'warehouse' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-warehouse"></i><span>Warehouse</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->route()->getName() == 'admin.warehouse.form_delivery_order' ? ' active' : '' }}">
                    <a class="nav-link" href="{{route('admin.warehouse.form_delivery_order')}}"><span>Form Delivery Order</span></a>
                </li>
                <li class="{{ request()->route()->getName() == 'admin.warehouse.confirm_delivery_order' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.warehouse.confirm_delivery_order') }}"><span>Confirm Delivery Order</span></a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'finance' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-chart-line"></i><span>Finance</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->route()->getName() == 'admin.finance.form_invoice_order' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.finance.form_invoice_order') }}"><span>Form Invoice Order</span></a>
                </li>
            </ul>
        </li>
        @if(Auth::user()->can('view-users'))
            <li class="dropdown {{ request()->segment(2) == 'master_data' ? ' active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-server"></i><span>Master Data</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->route()->getName() == 'admin.master_data.category.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.category.index') }}"><span>Category</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="index-0.html"><span>Customer Type</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="index-0.html"><span>Customer Group</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="index-0.html"><span>Customer</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="index-0.html"><span>Vendor</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.driver.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.driver.index') }}"><span>Driver</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.item.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.item.index') }}"><span>Item</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="index-0.html"><span>Price</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="index-0.html"><span>Modules</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.origin.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.origin.index') }}"><span>Origin</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.uom.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.uom.index') }}"><span>UOM</span></a>
                    </li>
                    <li class="">
                        <a class="nav-link" href="index-0.html"><span>Source Order</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.province.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.province.index') }}"><span>Province</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.residence.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.residence.index') }}"><span>Residence</span></a>
                    </li>
                    <li class="">
                         <router-link :to="{ name: 'users'}" class="nav-link"><span>Users</span></router-link>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</aside>
