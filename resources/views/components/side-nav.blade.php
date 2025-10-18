<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand text-danger fw-bold fst-italic" href="{{ route('admin.dashboard') }}">Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
      aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
      aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Admin panel</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link {{(request()->routeIs('admin.dashboard')) ? 'active text-primary' : '' }}"
              aria-current="page" href="{{ route('admin.dashboard') }}">Dashboard</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.showUsers')}}"
              class="nav-link  mt-2 py-1 {{(request()->routeIs('admin.showUsers')) ? 'active text-primary' : '' }} ">
              Users
            </a>
          </li>
          <li class="nav-item mt-2 ">
            <a href="{{ route('admin.showVehicles')}}"
              class="nav-link mt-2 py-1 {{(request()->routeIs('admin.showVehicles')) ? 'active text-primary' : '' }} ">
              Vehicles
            </a>
          </li>
          <div class="dropdown mt-3 ">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
              id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              Add
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow " aria-labelledby="dropdownUser1" style="">
              <li>
                <button type="button" class="dropdown-item btn text-white" data-bs-toggle="modal" data-bs-target="#company-modal">
                  New company
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item btn text-white" data-bs-toggle="modal" data-bs-target="#model-modal">
                  New model
                </button>
              </li>
              <li>
                <button type="button" class="dropdown-item btn text-white" data-bs-toggle="modal" data-bs-target="#admin-modal">
                  New admin
                </button>
              </li>
              
            </ul>
            <li class="nav-item mt-2">
              <a href="{{ route('admin.showAdmins') }}" class="nav-link {{ (request()->routeIs('admin.showAdmins')) ? 'active text-primary' : '' }}">Admins</a>
            </li>
          </div>

          <div class="dropdown mt-5">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdown"
              data-bs-toggle="dropdown" aria-expanded="false">
              <img src="{{ Storage::url(Auth::user()->image) }}" alt="" width="32" height="32"
                class="rounded-circle me-2">
              <strong>{{ Auth::user()->name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown" style="">
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
            </ul>
          </div>
        </ul>
        <form class="d-flex mt-3" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
          <button class="btn btn-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>