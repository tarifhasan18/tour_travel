<div class="main-panel">
<div class="main-header">
    <div class="main-header-logo">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="dark">
        <a href="{{url('/dashboard')}}" class="logo">
          <img
            src="{{asset('/Admincss/assets/img/bus.png')}}"
            alt="navbar brand"
            class="navbar-brand"
            height="20"
          />

        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
      <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav
      class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
    >
      <div class="container-fluid">
        <nav
          class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
        >
          <div class="input-group">
            <div class="input-group-prepend">
              {{-- <button type="submit" class="btn btn-search pe-1"> --}}
                {{-- <i class="fa fa-search search-icon"></i> --}}
              {{-- </button> --}}
              {{-- <h1>Dashboard</h1> --}}
            </div>
            {{-- <input
              type="text"
              placeholder="Search ..."
              class="form-control"
            /> --}}
          </div>
          <h1>Dashboard</h1>
        </nav>

        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
          <li
            class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
          >
            <a
              class="nav-link dropdown-toggle"
              data-bs-toggle="dropdown"
              href="#"
              role="button"
              aria-expanded="false"
              aria-haspopup="true"
            >
              <i class="fa fa-search"></i>
            </a>
            <ul class="dropdown-menu dropdown-search animated fadeIn">
              <form class="navbar-left navbar-form nav-search">
                <div class="input-group">
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div>
              </form>
            </ul>
          </li>
          <li class="nav-item topbar-icon dropdown hidden-caret">


          </li>

          {{-- <li class="nav-item topbar-icon dropdown hidden-caret">
            <a
              class="nav-link"
              data-bs-toggle="dropdown"
              href="#"
              aria-expanded="false"
            >
              <i class="fas fa-layer-group"></i>
            </a>

          </li> --}}

          <li class="nav-item topbar-user dropdown hidden-caret">
            <a
              class="dropdown-toggle profile-pic"
              data-bs-toggle="dropdown"
              href="#"
              aria-expanded="false"
            >
              <div class="avatar-sm">
                <img
                  src="{{asset('/Admincss/assets/img/user.jpg')}}"
                  alt="..."
                  class="avatar-img rounded-circle"
                />
              </div>
              <span class="profile-username">
                <span class="fw-bold">{{ auth()->user()->name }}</span>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
              <div class="dropdown-user-scroll scrollbar-outer">
                <li>
                  <div class="user-box">
                    <div class="avatar-lg">
                      <img
                        src="{{asset('/Admincss/assets/img/user.jpg')}}"
                        alt="image profile"
                        class="avatar-img rounded"
                      />
                    </div>
                    <div class="u-text">
                      <h4>{{auth()->user()->name}}</h4>
                      <p class="text-muted">{{auth()->user()->email}}</p>
                      <a
                        href="{{url('profile')}}"
                        class="btn btn-xs btn-secondary btn-sm"
                        >View Profile</a
                      >
                    </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{url('profile')}}">My Profile</a>
                  {{-- <a class="dropdown-item" href="#">My Balance</a> --}}
                  {{-- <a class="dropdown-item" href="{{url('view_message')}}">Inbox</a> --}}
                  {{-- <div class="dropdown-divider"></div> --}}
                  {{-- <a class="dropdown-item" href="#">Account Setting</a> --}}
                  <div class="dropdown-divider"></div>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
                </li>
              </div>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
  </div>
