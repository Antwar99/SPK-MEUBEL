<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <hr class="bs-sidenav-bar">
            <div class="nav">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                {{-- Master Data --}}
                <div class="sb-sidenav-menu-heading">Master Data</div>
                {{-- kriteria --}}
                @can('admin')
                    <a class="nav-link {{ Request::is('dashboard/kriteria*') ? 'active' : '' }}"
                        href="{{ route('kriteria.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-table-columns"></i></div>
                        Data Kriteria
                    </a>
                    <a class="nav-link {{ Request::is('dashboard/wood*') ? 'active' : '' }}"
                    href="{{ route('wood.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tree"></i> {{-- opsional: icon pohon sebagai representasi kayu --}}
                    </div>
                    Data Kayu
                </a>
                @endcan
              
                <a class="nav-link {{ Request::is('dashboard/perbandingan*') ? 'active' : '' }}"
                    href="{{ route('perbandingan.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-code-compare"></i>
                    </div>
                    Perbandingan
                </a>
                
                @can('admin')
                    <div class="sb-sidenav-menu-heading">Master Pengguna</div>
                    <a class="nav-link {{ Request::is('dashboard/users*') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-gear"></i></div>
                        Data Pengguna
                    </a>
                @endcan
                  {{-- Master User --}}
                <a class="nav-link {{ Request::is('dashboard/alternatif*') ? 'active' : '' }}"
                    href="{{ route('alternatif.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-rectangle"></i></div>
                    Data Alternatif
                </a>
                <a class="nav-link {{ Request::is('dashboard/ranking*') ? 'active' : '' }}"
                    href="{{ route('rank.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-ranking-star"></i></div>
                    Rangking
                </a>
                <a class="nav-link {{ Request::is('dashboard/profile*') ? 'active' : '' }}"
                    href="{{ route('profile.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-pen"></i></div>
                    Ubah Profil
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Masuk sebagai: <span>{{ auth()->user()->level }}</span></div>
        </div>
    </nav>
</div>
