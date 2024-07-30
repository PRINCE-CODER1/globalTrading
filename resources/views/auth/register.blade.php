
@include('components.header')
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row justify-content-center align-items-center h-100">         
                    <div class="col-xxl-7 col-xl-9 col-lg-6 col-md-6 col-sm-8 col-12">
                        <div class="card custom-card shadow-none my-4 p-1">
                            <div class="card-body p-4">
                                <div class="mb-3 d-flex justify-content-center">
                                    <a href="index-2.html">
                                        <img
                                        src="../assets/images/brand-logos/desktop-logo.png"
                                        alt="logo"
                                        class="authentication-brand desktop-logo"
                                        />
                                        <img
                                        src="../assets/images/brand-logos/desktop-dark.png"
                                        alt="logo"
                                        class="authentication-brand desktop-dark"
                                        />
                                    </a>
                                </div>
                                    <p class="h5 mb-2 text-center">Sign Up</p>
                                    <p class="mb-4 text-muted op-7 fw-normal text-center">
                                    Welcome & Join us by creating a free account !
                                    </p>
                            
                                <div class="row gy-3">
                                    <!-- Name -->
                                    <div class="col-xl-12">
                                        <label for="name"  class="form-label text-default">Name</label>
                                        <input id="name" placeholder="full name" class="form-control form-control-lg" type="text" name="name" required autofocus autocomplete="name" />        
                                    </div>
                                    <!-- Email -->
                                    <div class="col-xl-12">
                                      <label for="email" class="form-label text-default">Email</label>
                                      <input id="email" placeholder="email" class="form-control form-control-lg" type="email" name="email" required autofocus autocomplete="email" />
                                    </div>
                                  
                                    <!-- Password -->
                                    <div class="col-xl-12">
                                                <label for="password" class="form-label text-default" >password</label>
                                                <input id="password" class="form-control form-control-lg"
                                                                type="password"
                                                                name="password"
                                                                placeholder="password"
                                                                required autocomplete="new-password" />
                                    </div>
                                    <!-- Confirm Password -->
                                    <div class="col-xl-12 mb-3">
                                                <label for="password_confirmation" class="form-label text-default" >confirm password</label>
                                                    <div class="position-relative">
                                                        <input id="signup-confirmpassword" class="form-control form-control-lg"
                                                                type="password"
                                                                placeholder="confirm"
                                                                name="password_confirmation" required autocomplete="new-password" />
                                                            <a
                                                                href="javascript:void(0);"
                                                                class="show-password-button text-muted"
                                                                onclick="createpassword('signup-confirmpassword',this)"
                                                                id="button-addon21"
                                                                ><i class="ri-eye-off-line align-middle"></i
                                                                    ></a>
                                                    </div>
                                                    
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-lg btn-primary">Create Account</button>
                                </div>      
                                <div class="text-center">
                                    <p class="text-muted mt-3 mb-0">
                                        Already have an account?
                                        <a href="{{ route('login') }}" class="text-primary"
                                        >Sign In</a
                                        >
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </form>
      </div>
      <div class="col-xxl-7 col-lg-7 d-xl-block d-none px-0" style="overflow:hidden">
        <div class="authentication-cover bg-primary">
          <div>
            <div class="authentication-cover-image">
              <img class="img-fluid"  src="{{asset('assets/images/media/media-67.png')}}" alt="" />
            </div>
            <div class="text-center mb-4">
              <h1 class="text-fixed-white">Sign Up</h1>
            </div>
            <div class="btn-list text-center">
              <a
                href="javascript:void(0);"
                class="btn btn-icon authentication-cover-icon btn-wave"
              >
                <i class="ri-facebook-line fw-bold"></i>
              </a>
              <a
                href="javascript:void(0);"
                class="btn btn-icon authentication-cover-icon btn-wave"
              >
                <i class="ri-twitter-line fw-bold"></i>
              </a>
              <a
                href="javascript:void(0);"
                class="btn btn-icon authentication-cover-icon btn-wave"
              >
                <i class="ri-instagram-line fw-bold"></i>
              </a>
              <a
                href="javascript:void(0);"
                class="btn btn-icon authentication-cover-icon btn-wave"
              >
                <i class="ri-github-line fw-bold"></i>
              </a>
              <a
                href="javascript:void(0);"
                class="btn btn-icon authentication-cover-icon btn-wave"
              >
                <i class="ri-youtube-line fw-bold"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      
    </div>

   
@include('components.footer')

