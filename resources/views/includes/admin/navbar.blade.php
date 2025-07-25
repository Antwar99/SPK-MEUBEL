<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-7 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
            <a class="navbar-brand center ps-3" href="{{ route('dashboard.index') }}">
        SPK PEMILIHAN BAHAN BAKU KAYU {{ auth()->user()->level }}
    </a>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <span class="mr-2 d-none d-lg-inline text-white small">Selamat Datang, {{ auth()->user()->name }}</span>
    </form>

    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item btnLogout">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
