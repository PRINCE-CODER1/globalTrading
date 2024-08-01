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

                <!-- Start::slide -->
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
                            <a href="{{route('dashboard.index')}}" class="side-menu__item">Dashboards</a>
                        </li>
                        
                    </ul>
                </li>
                <!-- End::slide -->
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
                {{-- @can('view permissions') --}}
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
                        {{-- @can('view permissions') --}}
                        <li class="slide">
                            <a href="{{ route('permissions.index') }}" class="side-menu__item">Permissions</a>
                        </li>
                        {{-- @endcan --}}
                        {{-- @can('view roles') --}}
                        <li class="slide">
                            <a href="{{ route('roles.index') }}" class="side-menu__item">Roles</a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcan --}}
                <!-- End::Roles & Management -->
                <!-- Start::Segment -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item d-flex  align-items-center">
                        <i class="bi bi-grid side-menu__icon mb-0 me-2"></i>
                            <span class="side-menu__label">Master</span>
                        <i class="fe fe-chevron-right side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1 pages-ul">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Master</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('segments.index') }}" class="side-menu__item">Segments</a>
                        </li>
                        
                        <li class="slide">
                            <a href="{{ route('sub-segments.index') }}" class="side-menu__item">Sub-Segments</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('leads.index') }}" class="side-menu__item">Lead source</a>
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
                        
                    </ul>
                </li>
                <!-- End::Segment -->
                
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
<!-- End::app-sidebar -->