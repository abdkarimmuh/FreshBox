<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}"><img src="{{asset('assets/img/logo-freshbox.png')}}"></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{asset('assets/img/icon-freshbox.png')}}" width="32px" height="32px">
        </a>
    </div>
    <br>
    <br>
    <ul class="sidebar-menu">
        <li class="{{ Request::route()->getName() == 'admin.dashboard' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home"></i><span>Dashboard</span></a>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'marketing' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-bullhorn"></i><span>Marketing</span></a>
            <ul class="dropdown-menu">
                @if(request()->segment(2) != 'master_data' && request()->segment(2) != 'warehouse' && request()->segment(2) != 'procurement' && request()->segment(2) != 'report' )
                    <router-link :to="{ name: 'form_sales_order'}" v-slot="{ href, navigate, isActive }">
                        <li :class="[isActive && 'active']">
                            <a class="nav-link" :href="href" @click="navigate">Form Sales Order</a>
                        </li>
                    </router-link>
                @else
                    <li class="{{ request()->segment(3) == 'form_sales_order' ? ' active' : '' }}">
                        <a href="{{ url('admin/marketing/form_sales_order') }}"
                           class="nav-link"><span>Form Sales Order</span></a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'procurement' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-box-open"></i><span>Procurement</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->route()->getName() == 'admin.procurement.user_procurement.index' ? ' active' : '' }}">
                    <a class="nav-link" href="{{route('admin.procurement.user_procurement.index')}}"><span>User Procurement</span></a>
                </li>
                <li class="{{ request()->route()->getName() == 'admin.procurement.item_procurement.index' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.procurement.item_procurement.index') }}"><span>Item</span></a>
                </li>
                <li class="{{ request()->route()->getName() == 'admin.procurement.list_procurement.index' ? ' active' : '' }}">
                    <a class="nav-link"
                       href="{{ route('admin.procurement.list_procurement.index') }}"><span>Procurement</span></a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'warehouseIn' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-warehouse"></i><span>Warehouse In</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->route()->getName() == 'admin.warehouseIn.confirm.index' ? ' active' : '' }}">
                    <a class="nav-link" href="{{route('admin.warehouseIn.confirm.index')}}"><span>Confirm Incoming Items</span></a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'warehouse' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-truck"></i><span>Warehouse Out</span></a>
            <ul class="dropdown-menu">
                @if(request()->segment(2) != 'master_data' && request()->segment(2) != 'warehouse' && request()->segment(2) != 'procurement' && request()->segment(2) != 'report' )
                    <router-link :to="{ name: 'delivery_order.index'}" v-slot="{ href, navigate, isActive }">
                        <li :class="[isActive && 'active']">
                            <a class="nav-link" :href="href" @click="navigate">Form Delivery Order</a>
                        </li>
                    </router-link>
                @else
                    <li class="{{ request()->segment(3) == 'delivery-order' ? ' active' : '' }}">
                        <a class="nav-link"
                           href="{{url('admin/warehouse/delivery-order')}}"><span>Form Delivery Order</span></a>
                    </li>
                @endif

                <li class="{{ request()->segment(3) == 'confirm_delivery_order' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ url('admin/warehouse/confirm_delivery_order') }}"><span>Confirm Delivery Order</span></a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'finance' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-chart-line"></i><span>Finance</span></a>
            <ul class="dropdown-menu">
                @if(request()->segment(2) != 'master_data' && request()->segment(2) != 'warehouse' && request()->segment(2) != 'procurement' && request()->segment(2) != 'report' )
                    <router-link :to="{ name: 'invoice_order'}" v-slot="{ href, navigate, isActive }">
                        <li :class="[isActive && 'active']">
                            <a class="nav-link" :href="href" @click="navigate">Form Invoice Order</a>
                        </li>
                    </router-link>
                    <router-link :to="{ name: 'invoice_order.recap'}" v-slot="{ href, navigate, isActive }">
                        <li :class="[isActive && 'active']">
                            <a class="nav-link" :href="href" @click="navigate">Recap Invoice</a>
                        </li>
                    </router-link>
                    <router-link :to="{ name: 'submitRecap'}" v-slot="{ href, navigate, isActive }">
                        <li :class="[isActive && 'active']">
                            <a class="nav-link" :href="href" @click="navigate">Submitted Recap Invoice</a>
                        </li>
                    </router-link>
                @else
                    <li class="{{ request()->segment(3) == 'invoice_order' ? ' active' : '' }}">
                        <a href="{{ url('admin/finance/invoice-order') }}"
                           class="nav-link"><span>Form Invoice Order</span></a>
                    </li>
                @endif
                <li class="{{ request()->segment(3) == 'paid-recap' ? ' active' : '' }}">
                    <a href="{{ url('admin/finance/paid-recap') }}"
                       class="nav-link"><span>Paid Invoice Order</span></a>
                </li>
            </ul>
        </li>
        <li class="dropdown {{ request()->segment(2) == 'report' ? ' active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i><span>Report</span></a>
            <ul class="dropdown-menu">
                <li class="{{ request()->route()->getName() == 'admin.report.reportso.index' ? ' active' : '' }}">
                    <a class="nav-link" href="{{route('admin.report.reportso.index')}}"><span>SO Report</span></a>
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
                    <li class="{{ request()->route()->getName() == 'admin.master_data.item.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.item.index') }}"><span>Item</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.modules.index' ? ' active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.master_data.modules.index') }}"><span>Modules</span></a>
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.officer.index' ? ' active' : '' }}">
                        <a class="nav-link"
                           href="{{ route('admin.master_data.officer.index') }}"><span>Officer</span></a>
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
                    </li>
                    <li class="{{ request()->route()->getName() == 'admin.master_data.residence.index' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.master_data.residence.index') }}"><span>Residence</span></a>
                    </li> --}}
                    <li class="">
                        <a href="{{ route('admin.users') }}" class="nav-link"><span>Users</span></a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</aside>
