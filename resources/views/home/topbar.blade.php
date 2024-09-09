    <!-- Topbar Start -->
    <div class="container-fluid bg-light pt-3 d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center">
                        <p><i class="fa fa-envelope mr-2"></i>{{$site_settings->email}}</p>
                        <p class="text-body px-3">|</p>
                        <p><i class="fa fa-phone-alt mr-2"></i>{{$site_settings->phone}}</p>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-primary px-3" target="_blank" href="{{$site_settings->facebook}}">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-primary px-3" target="_blank" href="{{$site_settings->twitter}}">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-primary px-3" target="_blank" href="{{$site_settings->linkedin}}">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-primary px-3" target="_blank" href="{{$site_settings->instagram}}">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-primary pl-3" target="_blank" href="{{$site_settings->youtube}}">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="position-relative p-0 px-lg-3" style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-light navbar-light shadow-lg p-2 px-md-5">
                <a href="" class="navbar-brand">
                    <h7 class="m-0 text-primary"><span style="color: rgb(255, 136, 0)" class="text-red"> <img width="60" height="50" src="{{asset('tour_image/'.$site_settings->ui_logo)}}" alt=""> {{$site_settings->ui_site_name}}</h1>

                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="{{url('/')}}" class="{{request()->is('/')?'nav-item nav-link active':'nav-item nav-link'}}">Home</a>
                        <a href="{{url('about_us')}}" class="{{request()->is('about_us')?'nav-item nav-link active':'nav-item nav-link'}}">About Us</a>
                        <a href="{{url('our_services')}}" class="{{request()->is('our_services')?'nav-item nav-link active':'nav-item nav-link'}}">Our Services</a>
                        <a href="{{url('view_tour_packages')}}" class="{{request()->is('view_tour_packages')?'nav-item nav-link active':'nav-item nav-link'}}">Tour Packages</a>
                        <a href="{{url('contact_us')}}" class="{{request()->is('contact_us')?'nav-item nav-link active':'nav-item nav-link'}}">Contact Us</a>

                        @if (Route::has('login'))
                         @auth
                         <a class="{{request()->is('my_bookings')?'nav-item nav-link active':'nav-item nav-link'}}" href="{{url('my_bookings')}}">
                            {{-- {{ auth()->user()->name }} --}}
                            My Booking
                        </a>
                        <a class="nav-item nav-link" href="{{url('profile')}}"> Profile </a>
                            <form method="POST"  class="nav-item nav-link" action="{{ route('logout') }}">
                                @csrf

                                <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>



                        @else
                            <a href="{{url('/login')}}" class="nav-item nav-link">Login</a>
                            @if (Route::has('register'))

                            <a class="nav-item nav-link" href="{{url('register')}}">Register</a>

                             @endif
                            @endauth
                        @endif

                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
