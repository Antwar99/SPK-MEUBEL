@extends('layouts.portal')

@section('title')
    Portal
@endsection

@section('content')
    <!-- Jumbotron -->
    <section id="hero-animated" class="hero-animated d-flex align-items-center"
         style="background: url('{{ url('images/hero/hero.bg.jpg') }}') no-repeat center center; background-size: cover; min-height: 100vh; position: relative;">
      <div class="container pt-5" data-aos="zoom-out">
    <div class="row align-items-center">
        <!-- Teks di kiri -->
        <div class="col-md-5 text-start">
 <h1 style="font-size: 5rem; font-weight: bold;">SELAMAT DATANG</h1>
    <p style="font-size: 2rem;">DI SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN BAHAN BAKU KAYU TERBAIK</p>
            <div class="d-flex mt-7">
                @auth
                    <a href="{{ route('dashboard.index') }}" class="btn btn-dark">Beranda</a>
                @else
                    <a href="{{ route('login.index') }}" class="btn-get-started scrollto">Mulai</a>
                @endauth
            </div>
        </div>

        <!-- Gambar di kanan -->
        <div class="col-md-7 pt-6 text-center">
            <img src="{{ url('images/LOGO.png') }}" class="img-fluid animated" style="max-width: 300px;" />
        </div>
    </div>
</div>

    </section>
    <!-- End Jumbotron -->
    <main id="">
        <!-- ======= Featured Services Section ======= -->
        <section id="featured-services" class="featured-services">
            <div class="container ">
                <div class="row d-flex justify-content-betwen text-center">
                    <div class="col-xl-3 col-md-6" data-aos="zoom-out">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-people icon"></i></div>
                            <h4>
                                <a class="stretched-link"><span>{{ $woods }}</span> Kayu</a>
                            </h4>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 " data-aos="zoom-out" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-layout-text-sidebar icon"></i>
                            </div>
                            <h4>
                                <a class="stretched-link"><span>{{ $criterias }}</span> Kriteria</a>
                            </h4>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 " data-aos="zoom-out" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-building icon"></i>
                            </div>
                            <h4>
                                <a class="stretched-link"><span>{{ $categories }}</span> Kategori</a>
                            </h4>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 " data-aos="zoom-out" data-aos-delay="600">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-person-gear icon"></i></div>
                            <h4>
                                <a class="stretched-link"><span>{{ $users }}</span> Pengguna</a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection