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
                {{-- @role('Manager') --}}
                @can('view manager')
                <li class="slide has-sub {{ request()->routeIs('manager.dashboard') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house side-menu__icon mb-0"></i>
                        <span class="side-menu__label">Manager Dashboard</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Manager Dashboard</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('manager.dashboard') }}" class="side-menu__item {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">Manager Dashboard</a>
                        </li>
                    </ul>
                </li>
                @endcan
                {{-- @can('view user')
                <li class="slide has-sub {{ request()->routeIs('manager.customer-supplier.customer-supplier.index') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('manager.customer-supplier.customer-supplier.index') ? 'active' : '' }}">
                        <i class="ri-user-2-line side-menu__icon mb-0 d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Customer/Supplier</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Customer/Supplier</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('manager.customer-supplier.customer-supplier.index') }}" class="side-menu__item {{ request()->routeIs('manager.customer-supplier.customer-supplier.index') ? 'active' : '' }}">Customer/Supplier</a>
                        </li>
                    </ul>
                </li>
                @endcan --}}
                @can('view team')
                <li class="slide has-sub {{ request()->routeIs('teams.index') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('teams.index') ? 'active' : '' }}">
                        <i class="ri-team-fill side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Team</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Team</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('teams.index') }}" class="side-menu__item {{ request()->routeIs('teams.index') ? 'active' : '' }}">Team</a>
                        </li>
                    </ul>
                </li>
                @endcan
                
                {{-- <li class="slide has-sub {{ request()->routeIs('manager.leads.index') || request()->routeIs('manager.leads.create') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('teams.index') ? 'active' : '' }}">
                        <i class="ri-team-fill side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Leads</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Leads</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('manager.leads.index') }}" class="side-menu__item {{ request()->routeIs('manager.leads.index') ? 'active' : '' }}">View Leads</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('manager.leads.create') }}" class="side-menu__item {{ request()->routeIs('manager.leads.create') ? 'active' : '' }}">Create Leads</a>
                        </li>
                    </ul>
                </li> --}}

                {{-- isko dalna hai --}}
                {{-- <li class="slide has-sub {{ request()->routeIs('manager.lead') || request()->routeIs('manager.leads.create') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('manager.lead') || request()->routeIs('manager.leads.create') ? 'active' : '' }}">
                        <i class="ri-group-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Leads</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Leads</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('manager.leads.index') }}" class="side-menu__item {{ request()->routeIs('manager.leads.index') ? 'active' : '' }}">Leads</a>
                        </li>
                    </ul>
                </li>  --}}

                
                {{-- @endrole
                @role('Agent') --}}
                @can('view agent')
                <li class="slide has-sub {{ request()->routeIs('agent.dashboard') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house side-menu__icon mb-0"></i>
                        <span class="side-menu__label">Agent Dashboard</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Agent Dashboard</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('agent.dashboard') }}" class="side-menu__item {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">Agent Dashboard</a>
                        </li>
                    </ul>
                </li>
                @endcan

                @can('view leadside')
                <li class="slide has-sub {{ request()->routeIs('agent.lead') || request()->routeIs('agent.leads.create') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('agent.lead') || request()->routeIs('agent.leads.create') ? 'active' : '' }}">
                        <i class="ri-group-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Leads</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Leads</a>
                        </li>
                        @can('view lead')
                        <li class="slide">
                            <a href="{{ route('leads.index') }}" class="side-menu__item {{ request()->routeIs('leads.index') ? 'active' : '' }}">Leads</a>
                        </li>
                        @endcan
                    </ul>
                </li>  
                @endcan           
                
                {{-- @endrole --}}
                <!-- Start::slide -->
                {{-- @role('Super Admin') --}}
                @can('view admin')
                <li class="slide has-sub {{ request()->routeIs('admin.dashboard') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house side-menu__icon mb-0"></i>
                        <span class="side-menu__label">Dashboards</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Dashboards</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.dashboard') }}" class="side-menu__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Main Dashboard</a>
                        </li>
                    </ul>
                </li>
                @endcan
                
                 <!-- Start::User -->
                @can('view user')
                <li class="slide has-sub {{ request()->routeIs('users.index') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <i class="bi bi-person side-menu__icon mb-0 me-2"></i>
                        <span class="side-menu__label">User Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Users</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('users.index') }}" class="side-menu__item {{ request()->routeIs('users.index') ? 'active' : '' }}">Users</a>
                        </li>
                    </ul>
                </li>
                
                @endcan
                
                <!-- End::User -->
                <!-- Start::Roles & Management -->
                @can('view permissions')
                <li class="slide has-sub {{ request()->routeIs(['permissions.index', 'roles.index']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item  d-flex align-items-center {{ request()->routeIs(['permissions.index', 'roles.index']) ? 'active' : '' }}">
                        <i class="bi bi-gear side-menu__icon mb-0 me-2"></i>
                        <span class="side-menu__label">Roles & Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1 ">
                            <a href="javascript:void(0)">Roles & Management</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('permissions.index') }}" class="side-menu__item {{ request()->routeIs('permissions.index') ? 'active' : '' }}">Permissions</a>
                        </li>
                        
                        <li class="slide">
                            <a href="{{ route('roles.index') }}" class="side-menu__item  {{ request()->routeIs('roles.index') ? 'active' : '' }}">Roles</a>
                        </li>
                    </ul>
                </li>
                
                @endcan
                <!-- End::Roles & Management -->
                <!-- Start::Master -->
                @can('view master')
                <li class="slide has-sub {{ request()->routeIs([
                        'customer-supplier.index',
                        'products.index',
                        'segments.index',
                        'sub-segments.index',
                        'branches.index',
                        'workshops.index',
                        'units.index',
                        'stocks-categories.index',
                        'child-categories.index',
                        'godowns.index',
                        'taxes.index',
                        'master-numbering.index',
                        'challan-types.index',
                        'visits.index',
                        'series.index',
                        'lead-source.index',
                        'leads-status.index',
                        'leads-types.index',
                        'contractor.index'
                    ]) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs([
                        'customer-supplier.index',
                        'products.index',
                        'segments.index',
                        'sub-segments.index',
                        'branches.index',
                        'workshops.index',
                        'units.index',
                        'stocks-categories.index',
                        'child-categories.index',
                        'godowns.index',
                        'taxes.index',
                        'master-numbering.index',
                        'challan-types.index',
                        'visits.index',
                        'series.index',
                        'lead-source.index',
                        'leads-status.index',
                        'leads-types.index',
                        'contractor.index',
                    ]) ? 'active' : '' }}">
                        <i class="bi bi-grid side-menu__icon mb-0 me-2"></i>
                            <span class="side-menu__label">Master</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                          <a href="javascript:void(0)">Master</a>
                        </li>
                        @can('view cust-supp')
                        <li class="slide">
                          <a href="{{ route('customer-supplier.index') }}" class="side-menu__item  {{ request()->routeIs('customer-supplier.index') ? 'active' : '' }}">Customer/Supplier</a>
                        </li>
                        @endcan 
                      
                        @can('view products')
                        <li class="slide">
                          <a href="{{ route('products.index') }}" class="side-menu__item  {{ request()->routeIs('products.index') ? 'active' : '' }}">Products</a>
                        </li>
                        @endcan
                        @can('view segment')
                        <li class="slide">
                          <a href="{{ route('segments.index') }}" class="side-menu__item  {{ request()->routeIs('segments.index') ? 'active' : '' }}">Segments</a>
                        </li>
                        @endcan
                        @can('view subsegment')
                        <li class="slide">
                          <a href="{{ route('sub-segments.index') }}" class="side-menu__item  {{ request()->routeIs('sub-segments.index') ? 'active' : '' }}">Sub-Segments</a>
                        </li>
                        @endcan
                        @can('view branch')
                        <li class="slide">
                          <a href="{{ route('branches.index') }}" class="side-menu__item  {{ request()->routeIs('branches.index') ? 'active' : '' }}">Branch</a>
                        </li>
                        @endcan
                        @can('view workshop')
                        <li class="slide">
                          <a href="{{ route('workshops.index') }}" class="side-menu__item  {{ request()->routeIs('workshops.index') ? 'active' : '' }}">Workshop</a>
                        </li>
                        @endcan
                        @can('view unit')
                        <li class="slide">
                          <a href="{{ route('units.index') }}" class="side-menu__item  {{ request()->routeIs('units.index') ? 'active' : '' }}">Unit Of Measurement</a>
                        </li>
                        @endcan
                        @can('view stockcategory')
                        <li class="slide">
                          <a href="{{ route('stocks-categories.index') }}" class="side-menu__item {{ request()->routeIs('stocks-categories.index') ? 'active' : '' }}">Stock Categories</a>
                        </li>
                        @endcan
                        @can('view substockcategory')
                        <li class="slide">
                          <a href="{{ route('child-categories.index') }}" class="side-menu__item  {{ request()->routeIs('child-categories.index') ? 'active' : '' }}">Sub Categories</a>
                        </li>
                        @endcan
                        @can('view godown')
                        <li class="slide">
                          <a href="{{ route('godowns.index') }}" class="side-menu__item  {{ request()->routeIs('godowns.index') ? 'active' : '' }}">Godowns</a>
                        </li>
                        @endcan
                        @can('view tax')
                        <li class="slide">
                          <a href="{{ route('taxes.index') }}" class="side-menu__item  {{ request()->routeIs('taxes.index') ? 'active' : '' }}">Tax</a>
                        </li>
                        @endcan
                        @can('view numbernig')
                        <li class="slide">
                          <a href="{{ route('master-numbering.index') }}" class="side-menu__item  {{ request()->routeIs('master-numbering.index') ? 'active' : '' }}">Master Numbering</a>
                        </li>
                        @endcan
                        @can('view challantype')
                        <li class="slide">
                          <a href="{{ route('challan-types.index') }}" class="side-menu__item  {{ request()->routeIs('challan-types.index') ? 'active' : '' }}">Challan Types</a>
                        </li>
                        @endcan
                        @can('view visit')
                        <li class="slide">
                          <a href="{{ route('visits.index') }}" class="side-menu__item  {{ request()->routeIs('visits.index') ? 'active' : '' }}">Purpose Of Visit</a>
                        </li>
                        @endcan
                        @can('view series')
                        <li class="slide">
                          <a href="{{ route('series.index') }}" class="side-menu__item {{ request()->routeIs('series.index') ? 'active' : '' }}">Series</a>
                        </li>
                        @endcan
                        @can('view leadsource')
                        <li class="slide">
                          <a href="{{ route('lead-source.index') }}" class="side-menu__item  {{ request()->routeIs('lead-source.index') ? 'active' : '' }}">Lead Source</a>
                        </li>
                        @endcan
                        @can('view leadstatus')
                        <li class="slide">
                          <a href="{{ route('leads-status.index') }}" class="side-menu__item {{ request()->routeIs('leads-status.index') ? 'active' : '' }}">Lead Status</a>
                        </li>
                        @endcan
                        @can('view leadtype')
                        <li class="slide">
                          <a href="{{ route('leads-types.index') }}" class="side-menu__item {{ request()->routeIs('leads-types.index') ? 'active' : '' }}">Lead Types</a>
                        </li>
                        @endcan
                        @can('view contractor')
                        <li class="slide">
                          <a href="{{ route('contractor.index') }}" class="side-menu__item {{ request()->routeIs('contractor.index') ? 'active' : '' }}">Contractors</a>
                        </li>
                        @endcan
                      </ul>
                      
                </li>
                @endcan
                <!-- End::Master -->
                @can('view crm')
                <li class="slide has-sub {{ request()->routeIs('crm.index') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('crm.index') ? 'active' : '' }}">
                        <i class="ri-bar-chart-grouped-fill side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Crm</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Crm</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('crm.index') }}" class="side-menu__item {{ request()->routeIs('crm.index') ? 'active' : '' }}">Crm</a>
                        </li>
                    </ul>
                </li>
                @endcan
                <!-- Start::Inventory Management -->
                @can('view inventory')
                <li class="slide has-sub {{ request()->routeIs(['assemblies.index', 'purchase_orders.index', 'purchase.index', 'sale_orders.index', 'sales.index', 'stock_transfer.index']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs(['assemblies.index', 'purchase_orders.index', 'purchase.index', 'sale_orders.index', 'sales.index', 'stock_transfer.index']) ? 'active' : '' }}">
                        <i class="ri-store-2-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Inventory Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1 fs-13">
                            <a href="javascript:void(0)">Inventory Management</a>
                        </li>
                        
                        <li class="slide">
                            <a href="{{ route('assemblies.index') }}" class="side-menu__item {{ request()->routeIs('assemblies.index') ? 'active' : '' }}">Assembly</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('purchase_orders.index') }}" class="side-menu__item {{ request()->routeIs('purchase_orders.index') ? 'active' : '' }}">Purchase Order</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('purchase.index') }}" class="side-menu__item {{ request()->routeIs('purchase.index') ? 'active' : '' }}">Purchase</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('sale_orders.index') }}" class="side-menu__item {{ request()->routeIs('sale_orders.index') ? 'active' : '' }}">Sale Order</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('sales.index') }}" class="side-menu__item {{ request()->routeIs('sales.index') ? 'active' : '' }}">Sale</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('stock_transfer.index') }}" class="side-menu__item {{ request()->routeIs('stock_transfer.index') ? 'active' : '' }}">Stock Transfer</a>
                        </li>
                    </ul>
                </li>     
                @endcan           
                <!-- End::Inventory Management -->

                <!-- Start::Chalaan -->
                @can('view chalaan')
                <li class="slide has-sub {{ request()->routeIs(['internal.index', 'external.index', 'return-chalaan.index']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs(['internal.index', 'external.index', 'return-chalaan.index']) ? 'active' : '' }}">
                        <i class="ri-service-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Chalaan</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Chalaan</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('internal.index') }}" class="side-menu__item {{ request()->routeIs('internal.index') ? 'active' : '' }}">Internal Chalaan</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('external.index') }}" class="side-menu__item {{ request()->routeIs('external.index') ? 'active' : '' }}">External Chalaan</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('return-chalaan.index') }}" class="side-menu__item {{ request()->routeIs('return-chalaan.index') ? 'active' : '' }}">Return Chalaan</a>
                        </li>
                    </ul>
                </li>
                @endcan
                

                <!-- End::Chalaan -->
                {{-- @endrole --}}
                
                
                <!-- End::slide -->
               
                
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->