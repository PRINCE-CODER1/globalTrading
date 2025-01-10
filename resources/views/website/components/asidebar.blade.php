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
                    <li class="slide has-sub {{ request()->routeIs('leads.index') || request()->routeIs('leads.create') || request()->routeIs('leads.edit') ? 'open' : '' }}">
                        <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs('agent.leads.index') || request()->routeIs('leads.create')  || request()->routeIs('leads.edit') ? 'active' : '' }}">
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
                                    <a href="{{ route('leads.index') }}" class="side-menu__item {{ request()->routeIs('leads.index') || request()->routeIs('leads.create') || request()->routeIs('leads.edit') ? 'active' : '' }}">Leads</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan


                <!-- Start::slide -->
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
                <li class="slide has-sub {{ request()->routeIs(['users.index','users.create','users.edit']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs(['users.index','users.create','users.edit'])  ? 'active' : '' }}">
                        <i class="bi bi-person side-menu__icon mb-0 me-2"></i>
                        <span class="side-menu__label">User Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Users</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('users.index') }}" class="side-menu__item {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') ? 'active' : '' }}">Users</a>
                        </li>
                    </ul>
                </li>
                
                @endcan
                
                <!-- End::User -->
                <!-- Start::Roles & Management -->
                @can('view permissions')
                <li class="slide has-sub {{ request()->routeIs(['permissions.index','permissions.create','permissions.edit', 'roles.index','roles.create','roles.edit']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item  d-flex align-items-center {{ request()->routeIs(['permissions.index','permissions.create','permissions.edit', 'roles.index','roles.create','roles.edit']) ? 'active' : '' }}">
                        <i class="bi bi-gear side-menu__icon mb-0 me-2"></i>
                        <span class="side-menu__label">Roles & Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1 ">
                            <a href="javascript:void(0)">Roles & Management</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('permissions.index') }}" class="side-menu__item {{ request()->routeIs('permissions.index') || request()->routeIs('permissions.create') || request()->routeIs('permissions.edit') ? 'active' : '' }}">Permissions</a>
                        </li>
                        
                        <li class="slide">
                            <a href="{{ route('roles.index') }}" class="side-menu__item  {{ request()->routeIs('roles.index') || request()->routeIs('roles.create') || request()->routeIs('roles.edit') ? 'active' : '' }}">Roles</a>
                        </li>
                    </ul>
                </li>
                
                @endcan
                <!-- End::Roles & Management -->
                <!-- Start::Master -->
                @can('view master')
                <li class="slide has-sub {{ request()->routeIs([
                        'customer-supplier.index',
                        'customer-supplier.create',
                        'customer-supplier.edit',
                        'products.index',
                        'products.create',
                        'products.edit',
                        'segments.index',
                        'sub-segments.index',
                        'branches.index',
                        'branches.create',
                        'branches.edit',
                        'workshops.index',
                        'workshops.create',
                        'workshops.edit',
                        'units.index',
                        'units.create',
                        'units.edit',
                        'stocks-categories.index',
                        'stocks-categories.create',
                        'stocks-categories.edit',
                        'child-categories.index',
                        'child-categories.create',
                        'child-categories.edit',
                        'godowns.index',
                        'godowns.create',
                        'godowns.edit',
                        'taxes.index',
                        'taxes.create',
                        'taxes.edit',
                        'master-numbering.index',
                        'challan-types.index',
                        'challan-types.create',
                        'challan-types.edit',
                        'visits.index',
                        'visits.create',
                        'visits.edit',
                        'series.index',
                        'series.create',
                        'series.edit',
                        'lead-source.index',
                        'lead-source.create',
                        'lead-source.edit',
                        'leads-status.index',
                        'leads-status.create',
                        'leads-status.edit',
                        'leads-types.index',
                        'leads-types.create',
                        'leads-types.edit',
                        'contractor.index',
                        'contractor.create',
                        'contractor.edit',
                        'application.index',
                        'application.create',
                        'application.edit',
                    ]) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs([
                        'customer-supplier.index',
                        'customer-supplier.create',
                        'customer-supplier.edit',
                        'products.index',
                        'products.create',
                        'products.edit',
                        'segments.index',
                        'sub-segments.index',
                        'branches.index',
                        'branches.create',
                        'branches.edit',
                        'workshops.index',
                        'workshops.create',
                        'workshops.edit',
                        'units.index',
                        'units.create',
                        'units.edit',
                        'stocks-categories.index',
                        'stocks-categories.create',
                        'stocks-categories.edit',
                        'child-categories.index',
                        'child-categories.create',
                        'child-categories.edit',
                        'godowns.index',
                        'godowns.create',
                        'godowns.edit',
                        'taxes.index',
                        'taxes.create',
                        'taxes.edit',
                        'master-numbering.index',
                        'challan-types.index',
                        'challan-types.create',
                        'challan-types.edit',
                        'visits.index',
                        'visits.create',
                        'visits.edit',
                        'series.index',
                        'series.create',
                        'series.edit',
                        'lead-source.index',
                        'lead-source.create',
                        'lead-source.edit',
                        'leads-status.index',
                        'leads-status.create',
                        'leads-status.edit',
                        'leads-types.index',
                        'leads-types.create',
                        'leads-types.edit',
                        'contractor.index',
                        'contractor.create',
                        'contractor.edit',
                        'application.index',
                        'application.create',
                        'application.edit',
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
                          <a href="{{ route('customer-supplier.index') }}" class="side-menu__item  {{ request()->routeIs('customer-supplier.index') || request()->routeIs('customer-supplier.create') ||  request()->routeIs('customer-supplier.edit') ? 'active' : '' }}">Customer/Supplier</a>
                        </li>
                        @endcan 
                      
                        @can('view products')
                        <li class="slide">
                          <a href="{{ route('products.index') }}" class="side-menu__item  {{ request()->routeIs('products.index') || request()->routeIs('products.create') || request()->routeIs('products.edit') ? 'active' : '' }}">Products</a>
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
                          <a href="{{ route('branches.index') }}" class="side-menu__item  {{ request()->routeIs('branches.index') || request()->routeIs('branches.create') || request()->routeIs('branches.edit') ? 'active' : '' }}">Branch</a>
                        </li>
                        @endcan
                        @can('view workshop')
                        <li class="slide">
                          <a href="{{ route('workshops.index') }}" class="side-menu__item  {{ request()->routeIs('workshops.index') || request()->routeIs('workshops.create') || request()->routeIs('workshops.edit') ? 'active' : '' }}">Workshop</a>
                        </li>
                        @endcan
                        @can('view unit')
                        <li class="slide">
                          <a href="{{ route('units.index') }}" class="side-menu__item  {{ request()->routeIs('units.index') || request()->routeIs('units.create') || request()->routeIs('units.edit') ? 'active' : '' }}">Unit Of Measurement</a>
                        </li>
                        @endcan
                        @can('view stockcategory')
                        <li class="slide">
                          <a href="{{ route('stocks-categories.index') }}" class="side-menu__item {{ request()->routeIs('stocks-categories.index') || request()->routeIs('stocks-categories.create') || request()->routeIs('stocks-categories.edit') ? 'active' : '' }}">Stock Categories</a>
                        </li>
                        @endcan
                        @can('view substockcategory')
                        <li class="slide">
                          <a href="{{ route('child-categories.index') }}" class="side-menu__item  {{ request()->routeIs('child-categories.index') || request()->routeIs('child-categories.create') || request()->routeIs('child-categories.edit') ? 'active' : '' }}">Sub Categories</a>
                        </li>
                        @endcan
                        @can('view godown')
                        <li class="slide">
                          <a href="{{ route('godowns.index') }}" class="side-menu__item  {{ request()->routeIs('godowns.index') || request()->routeIs('godowns.create') || request()->routeIs('godowns.edit') ? 'active' : '' }}">Godowns</a>
                        </li>
                        @endcan
                        @can('view tax')
                        <li class="slide">
                          <a href="{{ route('taxes.index') }}" class="side-menu__item  {{ request()->routeIs('taxes.index') || request()->routeIs('taxes.create') || request()->routeIs('taxes.index') ? 'active' : '' }}">Tax</a>
                        </li>
                        @endcan
                        @can('view numbernig')
                        <li class="slide">
                          <a href="{{ route('master-numbering.index') }}" class="side-menu__item  {{ request()->routeIs('master-numbering.index') ? 'active' : '' }}">Master Numbering</a>
                        </li>
                        @endcan
                        @can('view challantype')
                        <li class="slide">
                          <a href="{{ route('challan-types.index') }}" class="side-menu__item  {{ request()->routeIs('challan-types.index') || request()->routeIs('challan-types.create') || request()->routeIs('challan-types.edit') ? 'active' : '' }}">Challan Types</a>
                        </li>
                        @endcan
                        @can('view visit')
                        <li class="slide">
                          <a href="{{ route('visits.index') }}" class="side-menu__item  {{ request()->routeIs('visits.index') || request()->routeIs('visits.create') || request()->routeIs('visits.edit') ? 'active' : '' }}">Purpose Of Visit</a>
                        </li>
                        @endcan
                        @can('view series')
                        <li class="slide">
                          <a href="{{ route('series.index') }}" class="side-menu__item {{ request()->routeIs('series.index') || request()->routeIs('series.create') || request()->routeIs('series.edit')  ? 'active' : '' }}">Series</a>
                        </li>
                        @endcan
                        @can('view leadsource')
                        <li class="slide">
                          <a href="{{ route('lead-source.index') }}" class="side-menu__item  {{ request()->routeIs('lead-source.index') || request()->routeIs('lead-source.create') || request()->routeIs('lead-source.edit') ? 'active' : '' }}">Lead Source</a>
                        </li>
                        @endcan
                        @can('view leadstatus')
                        <li class="slide">
                          <a href="{{ route('leads-status.index') }}" class="side-menu__item {{ request()->routeIs('leads-status.index') || request()->routeIs('leads-status.create') || request()->routeIs('leads-status.edit') ? 'active' : '' }}">Lead Status</a>
                        </li>
                        @endcan
                        @can('view leadtype')
                        <li class="slide">
                          <a href="{{ route('leads-types.index') }}" class="side-menu__item {{ request()->routeIs('leads-types.index') || request()->routeIs('leads-types.create') || request()->routeIs('leads-types.edit') ? 'active' : '' }}">Lead Types</a>
                        </li>
                        @endcan
                        @can('view contractor')
                        <li class="slide">
                          <a href="{{ route('contractor.index') }}" class="side-menu__item {{ request()->routeIs('contractor.index') || request()->routeIs('contractor.create') || request()->routeIs('contractor.edit') ? 'active' : '' }}">Contractors</a>
                        </li>
                        @endcan
                        @can('view application')
                        <li class="slide">
                          <a href="{{route('application.index')}}" class="side-menu__item {{ request()->routeIs('application.index') || request()->routeIs('application.create') || request()->routeIs('application.edit') ? 'active' : '' }}">Appliation</a>
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
                <li class="slide has-sub {{ request()->routeIs(['assemblies.index','assemblies.create','assemblies.edit', 'purchase_orders.index','purchase_orders.create','purchase_orders.edit', 'purchase.index', 'purchase.create', 'purchase.edit', 'sale_orders.index','sale_orders.create','sale_orders.edit', 'sales.index','sales.create','sales.edit']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs(['assemblies.index','assemblies.create','assemblies.edit', 'purchase_orders.index','purchase_orders.create','purchase_orders.edit', 'purchase.index', 'purchase.create', 'purchase.edit', 'sale_orders.index','sale_orders.create','sale_orders.edit', 'sales.index','sales.create','sales.edit']) ? 'active' : '' }}">
                        <i class="ri-store-2-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Inventory Management</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1 fs-13">
                            <a href="javascript:void(0)">Inventory Management</a>
                        </li>
                        
                        <li class="slide">
                            <a href="{{ route('assemblies.index') }}" class="side-menu__item {{ request()->routeIs('assemblies.index') || request()->routeIs('assemblies.create') || request()->routeIs('assemblies.edit') ? 'active' : '' }}">Assembly</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('purchase_orders.index') }}" class="side-menu__item {{ request()->routeIs('purchase_orders.index') || request()->routeIs('purchase_orders.create') || request()->routeIs('purchase_orders.edit') ? 'active' : '' }}">Purchase Order</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('purchase.index') }}" class="side-menu__item {{ request()->routeIs('purchase.index') || request()->routeIs('purchase.create') || request()->routeIs('purchase.edit') ? 'active' : '' }}">Purchase</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('sale_orders.index') }}" class="side-menu__item {{ request()->routeIs('sale_orders.index') || request()->routeIs('sale_orders.create') || request()->routeIs('sale_orders.edit') ? 'active' : '' }}">Sale Order</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('sales.index') }}" class="side-menu__item {{ request()->routeIs('sales.index') || request()->routeIs('sales.create') || request()->routeIs('sales.edit') ? 'active' : '' }}">Sale</a>
                        </li>
                    </ul>
                </li>     
                @endcan           
                <!-- End::Inventory Management -->

                <!-- Start::Chalaan -->
                @can('view chalaan')
                <li class="slide has-sub {{ request()->routeIs(['internal.index','internal.create','internal.edit', 'external.index','external.create','external.edit', 'return-chalaan.index','return-chalaan.create','return-chalaan.edit']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs(['internal.index','internal.create','internal.edit', 'external.index','external.create','external.edit', 'return-chalaan.index','return-chalaan.create','return-chalaan.edit']) ? 'active' : '' }}">
                        <i class="ri-service-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Chalaan</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Chalaan</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('internal.index') }}" class="side-menu__item {{ request()->routeIs('internal.index') || request()->routeIs('internal.create') || request()->routeIs('internal.edit') ? 'active' : '' }}">Internal Chalaan</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('external.index') }}" class="side-menu__item {{ request()->routeIs('external.index') || request()->routeIs('external.create') || request()->routeIs('external.edit') ? 'active' : '' }}">External Chalaan</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('return-chalaan.index') }}" class="side-menu__item {{ request()->routeIs('return-chalaan.index') || request()->routeIs('return-chalaan.create') || request()->routeIs('return-chalaan.edit') ? 'active' : '' }}">Return Chalaan</a>
                        </li>
                    </ul>
                </li>
                @endcan
                

                <!-- End::Chalaan -->
                {{-- @endrole --}}
                
                
                <!-- End::slide -->

                <!-- Start::Daily Report Of Employes -->
               @can('DarSide')
                <li class="slide has-sub {{ request()->routeIs(['dar.daily-rep','user-reports']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs(['dar.daily-rep','user-reports']) ? 'active' : '' }}">
                        <i class="ri-record-mail-fill side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Daily Activity Reports</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">DAR</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('dar.daily-rep')}}" class="side-menu__item {{ request()->routeIs('dar.daily-rep') || request()->routeIs('user-reports') ? 'active' : '' }}">DAR</a>
                        </li>
                    </ul>
                </li>
               @endcan
               <!-- End::Daily Report Of Employes -->
               <!-- Start::Daily Report Of Employes -->
               @can('view dar-form')
                <li class="slide has-sub {{ request()->routeIs(['daily-report.index','daily-report.create','daily-report.edit']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center {{ request()->routeIs(['daily-report.index','daily-report.create','daily-report.edit']) ? 'active' : '' }}">
                        <i class="ri-record-mail-fill side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">DAR</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">DAR</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('daily-report.index')}}" class="side-menu__item {{ request()->routeIs('daily-report.index') || request()->routeIs('daily-report.create') || request()->routeIs('daily-report.edit') ? 'active' : '' }}">DAR</a>
                        </li>
                    </ul>
                </li>
                @endcan
                <!-- End::Daily Report Of Employes -->

                <!-- Start::Reports -->
                @can('stock reports')
                <li class="slide has-sub {{ request()->routeIs(['stock.reports','saleorder.reports','purchaseorder.reports','sale.reports','purchase.reports']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center ">
                        <i class="ri-line-chart-fill side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Reports</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Reports</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('stock.reports')}}" class="side-menu__item {{ request()->routeIs('stock.reports') ? 'active' : '' }}">Stock Reports</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('saleorder.reports')}}" class="side-menu__item {{ request()->routeIs('saleorder.reports') ? 'active' : '' }}">Sale Order Reports</a>
                        </li>
                        <li class="slide">
                            <a href="{{route('purchaseorder.reports')}}" class="side-menu__item {{ request()->routeIs('purchaseorder.reports') ? 'active' : '' }}">Purchase Order </a>
                        </li>
                        <li class="slide">
                            <a href="{{route('sale.reports')}}" class="side-menu__item {{ request()->routeIs('sale.reports') ? 'active' : '' }}">Sale Reports </a>
                        </li>
                        <li class="slide">
                            <a href="{{route('purchase.reports')}}" class="side-menu__item {{ request()->routeIs('purchase.reports') ? 'active' : '' }}">Purchase Reports </a>
                        </li>
                    </ul>
                </li>
                @endcan
                <!-- End::Reports -->
                @can('view import')
                <li class="slide has-sub {{ request()->routeIs(['product-reports.import']) ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="side-menu__item d-flex align-items-center ">
                        <i class="ri-import-line side-menu__icon d-flex justify-content-center align-items-center"></i>
                        <span class="side-menu__label">Import</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul custom-h">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Import</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('product-reports.import') }}" 
                               class="side-menu__item {{ request()->routeIs('product-reports.import') ? 'active' : '' }}">
                               Import
                            </a>
                        </li>
                    </ul>
                </li>                
                @endcan

                
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->