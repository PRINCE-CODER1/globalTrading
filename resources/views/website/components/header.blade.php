<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Global Trading')</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard">
    <meta name="Author" content="Global Trading">
	<meta name="keywords" content="global trading ,crm ,erp">
    
<!-- Favicon -->
<link rel="icon" href="{{asset('../assets/images/gtimage/logo_icon.png')}}" type="image/x-icon">
    
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Choices JS -->
<script src="{{asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>

<!-- Main Theme Js -->
<script src="{{asset('assets/js/main.js')}}"></script>
    
<!-- Bootstrap Css -->
<link id="style" href="{{asset('assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" >

<!-- Style Css -->
<link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" >

<!-- Icons Css -->
<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" >

<!-- Node Waves Css -->
<link href="{{asset('assets/libs/node-waves/waves.min.css')}}" rel="stylesheet" > 

<!-- Simplebar Css -->
<link href="{{asset('assets/libs/simplebar/simplebar.min.css')}}" rel="stylesheet" >
    
<!-- Color Picker Css -->
<link rel="stylesheet" href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/libs/%40simonwep/pickr/themes/nano.min.css')}}">

<!-- Choices Css -->
<link rel="stylesheet" href="{{asset('assets/libs/choices.js/public/assets/styles/choices.min.css')}}">

<link rel="stylesheet" href="{{asset('assets/libs/jsvectormap/css/jsvectormap.min.css')}}">

<link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css')}}">

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>

{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
@livewireStyles

</head>

<body>



    <!-- Loader -->
<div id="loader" >
    <img src="https://spruko.com/demo/udon/dist/assets/images/media/loader.svg" alt="">
</div>
<!-- Loader -->

<div class="page">
            <!-- app-header -->
                <header class="app-header">

                    <!-- Start::main-header-container -->
                    <div class="main-header-container container-fluid">

                        <!-- Start::header-content-left -->
                        <div class="header-content-left">

                            <!-- Start::header-element -->
                            <div class="header-element">
                                <div class="horizontal-logo">
                                    <a href="index-2.html" class="header-logo">
                                        <img src="{{asset('../assets/images/gtimage/logo_white.png')}}" alt="logo" class="desktop-logo">
                                        <img src="{{asset('../assets/images/gtimage/logo_icon.png')}}" alt="logo" class="toggle-logo">
                                        <img src="{{asset('../assets/images/gtimage/logo_white.png')}}" alt="logo" class="desktop-dark">
                                        <img src="{{asset('../assets/images/gtimage/logo_icon.png')}}" alt="logo" class="toggle-dark">
                                    </a>
                                </div>
                            </div>
                            <!-- End::header-element -->

                            <!-- Start::header-element -->
                            <div class="header-element mx-lg-0 mx-2">
                                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                            </div>
                            <!-- End::header-element --> 

                        </div>
                        <!-- End::header-content-left -->

                        <!-- Start::header-content-right -->
                        <ul class="header-content-right">

                            <!-- Start::header-element -->
                            <li class="header-element d-md-none d-block">
                                <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#header-responsive-search">
                                    <!-- Start::header-link-icon -->
                                    <i class="bi bi-search header-link-icon"></i>
                                    <!-- End::header-link-icon -->
                                </a>  
                            </li>
                            <!-- End::header-element -->

                           



                            <!-- Start::header-element -->
                            <li class="header-element">
                                <!-- Start::header-link|dropdown-toggle -->
                                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="me-sm-2 me-0">
                                            <img src="{{asset('../assets/images/faces/9.jpg')}}" alt="img" class="avatar avatar-sm avatar-rounded">
                                        </div>
                                        <div class="d-xl-block d-none lh-1">
                                            <span class="fw-medium lh-1">{{Auth::user()->name}} ({{Auth::user()->roles->pluck('name')->implode(', ')}})</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- End::header-link|dropdown-toggle -->
                                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('users.edit',Auth::user()->id)}}"><i class="bi bi-person fs-18 me-2 op-7"></i>Profile</a></li>
                                    <li>
                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            
                                            <button type="submit" class="dropdown-item d-flex align-items-center"><i class="bi bi-box-arrow-right fs-16 me-2 op-7"></i>
                                                Log Out</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>  
                            <!-- End::header-element -->


                        </ul>
                        <!-- End::header-content-right -->

                    </div>
                    <!-- End::main-header-container -->

                </header>
            <!-- /app-header -->