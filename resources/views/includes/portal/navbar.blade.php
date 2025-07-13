    <!-- ======= Header ======= -->
   <header id="header" class="header fixed-top" data-scrollto-offset="0" style= "background-color: rgb(45, 86, 139)">
    <style>
        .header-hidden {
    transform: translateY(-100%);
    transition: transform 0.5s ease-in-out;
}

.header {
    transition: transform 0.5s ease-in-out;
}

    </style>
    <div class="container d-flex justify-content-between align-items-center py-3">
        
        {{-- Nav kiri --}}
        <nav id="navbar" class="d-flex align-items-center">
            <ul class="d-flex gap-3 mb-0 list-unstyled">
                <li>
                    <a class="btn btn-light scrollto" href="{{ url('/') }}">Beranda</a>
                </li>
                <li>
                    <a class="btn btn-light scrollto" href="{{ url('#about') }}">Tentang</a>
                </li>
                <li>
                    <a class="btn btn-light scrollto" href="{{ url('#faq') }}">FAQ</a>
                </li>
            </ul>
        </nav>

        {{-- Tombol kanan --}}
        @auth
            <a class="btn-dashborad-dark scrollto " href="{{ route('dashboard.index') }}">Dashboard</a>
        @else
            <a class="btn-getstarted scrollto" href="{{ route('login.index') }}">Mulai</a>
        @endauth

    </div>
    <script>
    let lastScrollTop = 0;
    const header = document.getElementById("header");

    window.addEventListener("scroll", function () {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop) {
            // Scroll ke bawah → sembunyikan navbar
            header.classList.add("header-hidden");
        } else {
            // Scroll ke atas → tampilkan navbar
            header.classList.remove("header-hidden");
        }

        lastScrollTop = scrollTop;
    });
</script>

</header>
