<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="index-2.html" class="header-logo">
            <img src="{{asset('assets/images/gtimage/logo_white.png')}}" alt="logo" class="desktop-logo">
            <img src="{{asset('assets/images/gtimage/logo_white.png')}}" alt="logo" class="toggle-dark">
            <img src="{{asset('assets/images/gtimage/logo_icon.png')}}" alt="logo" class="desktop-dark">
            <img src="{{asset('assets/images/gtimage/logo_icon.png')}}" alt="logo" class="toggle-logo">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
            </div>
            <ul class="main-menu">
                @role('Manager')
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center">
                        <i class="bi bi-house side-menu__icon mb-0"></i>
                        <span class="side-menu__label">Manager Dashboard</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Manager Dashboard</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('manager.dashboard')}}" class="side-menu__item">Manager Dashboard</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center">
                        <i class="ri-team-fill side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Team</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Team</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('teams.index')}}" class="side-menu__item">Team</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub {{ request()->routeIs('manager.leads.index') || request()->routeIs('manager.leads.create') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center">
                        <i class="ri-group-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Leads</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Leads</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('agent.leads.index') }}" class="side-menu__item">View Leads</a>
                        </li>
                    </ul>
                </li>
                @endrole
                @role('Agent')
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center">
                        <i class="bi bi-house side-menu__icon mb-0"></i>
                        <span class="side-menu__label">Agent Dashboard</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Agent Dashboard</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('agent.dashboard')}}" class="side-menu__item">Agent Dashboard</a>
                        </li>
                    </ul>
                </li>
                <li class="slide has-sub {{ request()->routeIs('agent.lead') || request()->routeIs('agent.leads.create') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex  align-items-center">
                        <i class="ri-group-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                            <span class="side-menu__label">Leads</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Leads</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('agent.leads.index')}}" class="side-menu__item">Leads</a>
                        </li>
                    </ul>
                </li>
                
                @endrole
                <!-- Start::slide -->
                @role('Super Admin')
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center">
                        <i class="bi bi-house side-menu__icon mb-0"></i>
                        <span class="side-menu__label">Dashboards</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Dashboards</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('admin.dashboard')}}" class="side-menu__item">Main Dashboard</a>
                        </li>
                    </ul>
                </li>
                 <!-- Start::User -->
                {{-- @can('view user') --}}
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex  align-items-center">
                        <i class="bi bi-person side-menu__icon mb-0 me-2"></i>
                            <span class="side-menu__label">User Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Users</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('users.index')}}" class="side-menu__item">Users</a>
                        </li>
                        
                    </ul>
                </li>
                {{-- @endcan --}}
                
                <!-- End::User -->
                <!-- Start::Roles & Management -->
                @can('view permissions')
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex  align-items-center">
                        <i class="bi bi-gear side-menu__icon mb-0 me-2"></i>
                        <span class="side-menu__label">Roles & Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Roles & Management</a>
                        </li>
                        @can('view permissions')
                        <li class="slide">
                            <a href="{{ route('permissions.index') }}" class="side-menu__item">Permissions</a>
                        </li>
                        @endcan
                        @can('view roles')
                        <li class="slide">
                            <a href="{{ route('roles.index') }}" class="side-menu__item">Roles</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                <!-- End::Roles & Management -->
                <!-- Start::Master -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex  align-items-center">
                        <i class="bi bi-grid side-menu__icon mb-0 me-2"></i>
                            <span class="side-menu__label">Master</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Master</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('customer-supplier.index') }}" class="side-menu__item">Customer/Supplier</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('products.index') }}" class="side-menu__item">Products</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('segments.index') }}" class="side-menu__item">Segments</a>
                        </li>
                        
                        <li class="slide">
                            <a href="{{ route('sub-segments.index') }}" class="side-menu__item">Sub-Segments</a>
                        </li>
                        
                        <li class="slide">
                            <a href="{{ route('branches.index') }}" class="side-menu__item">Branch</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('workshops.index') }}" class="side-menu__item">Workshop</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('units.index') }}" class="side-menu__item">Unit Of Measurement</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('stocks-categories.index') }}" class="side-menu__item">Stock Categories</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('child-categories.index') }}" class="side-menu__item">Sub Categories</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('godowns.index') }}" class="side-menu__item">Godowns</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('taxes.index') }}" class="side-menu__item">Tax</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('master-numbering.index') }}" class="side-menu__item">Master Numbering</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('challan-types.index') }}" class="side-menu__item">Challan Types</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('visits.index') }}" class="side-menu__item">Purpose Of Visit</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('series.index') }}" class="side-menu__item">Series</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('leads.index') }}" class="side-menu__item">Lead source</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('leads-status.index') }}" class="side-menu__item">Lead Status</a>
                        </li>
                    </ul>
                </li>
                <!-- End::Master -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center">
                        <i class="ri-bar-chart-grouped-fill side-menu__icon d-flex justify-content-center align-items-center"></i>
                            <span class="side-menu__label">Crm</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Crm</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('crm.index') }}" class="side-menu__item">Crm</a>
                        </li>
                    </ul>
                </li>
                <!-- Start::Inventory Management -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center">
                        <i class="ri-store-2-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                            <span class="side-menu__label">Inventory Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1 fs-13">
                            <a href="javascript:void(0)">Inventory Management</a>
                        </li>
                        
                        
                        <li class="slide">
                            <a href="{{ route('assemblies.index') }}" class="side-menu__item">Assembly</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('purchase_orders.index') }}" class="side-menu__item">Purchase Order</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('purchase.index') }}" class="side-menu__item">Purchase</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('sale_orders.index') }}" class="side-menu__item">Sale Order</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('sales.index') }}" class="side-menu__item">Sale</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('stock_transfer.index') }}" class="side-menu__item">Stock Transfer</a>
                        </li>
                        
                    </ul>
                </li>
                <!-- End::Inventory Management -->

                <!-- Start::Chalaan -->

                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center">
                        <i class="ri-service-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                            <span class="side-menu__label">Chalaan</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Chalaan</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('chalaan.index') }}" class="side-menu__item">Internal Chalaan</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('external.index') }}" class="side-menu__item">External Chalaan</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('chalaan.index') }}" class="side-menu__item">Return Chalaan</a>
                        </li>
                    </ul>
                </li>

                <!-- End::Chalaan -->
                @endrole
                
                
                <!-- End::slide -->
               
                
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->