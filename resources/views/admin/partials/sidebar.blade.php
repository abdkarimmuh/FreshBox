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
                <li class="{{ request()->route()->getName() == 'admin.marketing.sales_order.index' ? ' active' : '' }}">
                    <a href="{{ route('admin.marketing.sales_order.index') }}" class="nav-link"><span>Form Sales Order</span></a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'warehouse' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-warehouse"></i><span>Warehouse</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->route()->getName() == 'admin.warehouse.delivery_order.index' ? ' active' : '' }}">
                    <a class="nav-link" href="{{route('admin.warehouse.delivery_order.index')}}"><span>Form Delivery Order</span></a>
                </li>
                <li class="{{ request()->route()->getName() == 'admin.warehouse.confirm_delivery_order.index' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.warehouse.confirm_delivery_order.index') }}"><span>Confirm Delivery Order</span></a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'finance' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-chart-line"></i><span>Finance</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->route()->getName() == 'admin.finance.invoice_order.index' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.finance.invoice_order.index') }}"><span>Form Invoice Order</span></a>
                </li>
            </ul>
        </li>
        @if(Auth::user()->can('view-users'))
            <li class="dropdown {{ request()->segment(2) == 'master_data' ? ' active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-server"></i><span>Master Data</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->route()->getName() == 'admin.master_data.bank.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.bank.index') }}"><span>Bank</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.category.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.category.index') }}"><span>Category</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.customer.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.customer.index') }}"><span>Customer</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.customer_group.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.customer_group.index') }}"><span>Customer Group</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.customer_type.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.customer_type.index') }}"><span>Customer Type</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.driver.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.driver.index') }}"><span>Driver</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.item.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.item.index') }}"><span>Item</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.modules.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.modules.index') }}"><span>Modules</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.origin.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.origin.index') }}"><span>Origin</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.price.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.price.index') }}"><span>Price</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.source_order.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.source_order.index') }}"><span>Source Order</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.uom.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.uom.index') }}"><span>UOM</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.vendor.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.vendor.index') }}"><span>Vendor</span></a>
                    </li>
                    {{-- <li class="{{ request()->route()->getName() == 'admin.master_data.province.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.province.index') }}"><span>Province</span></a>
                    </li> --}}
                    {{-- <li class="{{ request()->route()->getName() == 'admin.master_data.residence.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.residence.index') }}"><span>Residence</span></a>
                    </li> --}}
                    <li class="">
                         <router-link :to="{ name: 'users'}" class="nav-link"><span>Users</span></router-link>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</aside>
