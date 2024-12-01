@include('components.header')
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row justify-content-center align-items-center h-100">
                        <div class="col-xxl-7 col-xl-9 col-lg-6 col-md-6 col-sm-8 col-12">
                            <div class="card custom-card shadow-none my-4">
                                <div class="card-body p-4">
                                    <div class="mb-3 d-flex justify-content-center">
                                        <a href="index-2.html">
                                            <img src="{{asset('../assets/images/gtimage/logo_icon.png')}}" alt="logo" class="authentication-brand desktop-logo">
                                            <img src="{{asset('../assets/images/gtimage/logo_icon.png')}}" alt="logo" class="authentication-brand desktop-dark">
                                        </a>
                                    </div>
                                <p class="h5 mb-2 text-center">Sign In</p>
                                @if (Auth::check())
                                    <p class="mb-4 text-muted op-7 fw-normal text-center">Welcome back {{Auth::user()->name}} </p>
                                    @else
                                    <p class="mb-4 text-muted op-7 fw-normal text-center">Welcome back</p>
                                @endif
                                <div class="row gy-3">

                                    <!-- Email Address -->
                                    <div>
                                        <x-input-label for="email" :value="__('Email')" class="form-label text-default"/>
                                        <x-text-input id="email" class="form-control form-control-lg" type="email" name="email" placeholder="enter email" :value="old('email')" required autofocus autocomplete="email" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    
                                    <!-- Password -->
                                    <div class="col-xl-12 mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <x-input-label for="password" :value="__('Password')" class="mb-0 form-label text-default d-block" />
                                            @if (Route::has('password.request'))
                                            <a class="float-end text-danger fs-10" href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                            @endif
                                        </div>
                                        
                                        <x-text-input id="password" class="form-control form-control-lg"
                                                        type="password"
                                                        name="password"
                                                        placeholder="password"
                                                        required autocomplete="current-password" />

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        <!-- Remember Me -->
                                        <div class="block mt-4">
                                            <label for="remember_me" class="inline-flex items-center">
                                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>                            
                                <div class="d-grid mt-4">
                                        <button type="submit" class="btn btn-lg btn-secondary" wire:navigate>Sign In</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </form>
        </div>
        <div class="col-xxl-7 col-xl-7 col-lg-7 d-xl-block d-none px-0">
            <div class="authentication-cover bg-primary">
                <div>
                    <div class="authentication-cover-image">
                        <img src="{{asset('assets/images/media/media-67.png')}}" alt="">
                    </div>
                    <div class="text-center mb-4">
                        <h1 class="text-fixed-white">Sign In</h1>
                    </div>
                    <div class="btn-list text-center">
                        <a href="javascript:void(0);" class="btn btn-icon authentication-cover-icon btn-wave">
                            <i class="ri-facebook-line fw-bold"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-icon authentication-cover-icon btn-wave">
                            <i class="ri-twitter-line fw-bold"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-icon authentication-cover-icon btn-wave">
                            <i class="ri-instagram-line fw-bold"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-icon authentication-cover-icon btn-wave">
                            <i class="ri-github-line fw-bold"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-icon authentication-cover-icon btn-wave">
                            <i class="ri-youtube-line fw-bold"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@include('components.footer')