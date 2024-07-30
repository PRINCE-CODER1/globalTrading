@include('website.components.header')
            @include('website.components.asidebar')

            <!-- Start::app-content -->
            <div class="main-content app-content">
                <div>
                    @yield('content')
                </div>
            </div>
            <!-- End::app-content -->  
        
@include('website.components.footer')