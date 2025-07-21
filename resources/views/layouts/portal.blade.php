<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- Pastikan favicon ini file, bukan folder --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/favicon.ico') }}" />
    <title>SPK | @yield('title')</title>
    {{-- style css --}}
    @include('includes.portal.style')
</head>

<body>
    {{-- navbar --}}
    @include('includes.portal.navbar')

    <!-- Main -->
    <main>
        @yield('content')

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>Tentang</h2>
                    <p>
                        Selamat datang di platform yang bertujuan untuk memberikan
                        solusi inovatif dalam pemilihan bahan baku kayu berkualitas terbaik untuk kerajinan meubel
                        menggunakan Sistem Pendukung Keputusan (SPK). Sistem yang dirancang ini bertujuan untuk
                        menentukan kayu jenis apa yang sebaiknya digunakan untuk produksi sebuah kerajinan tertentu dengan
                        perhitungan AHP dan SAW.
                    </p>
                </div>

                <div class="row g-4 g-lg-5 align-items-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-lg-5">
                        <div class="about-img">
                            <img src="{{ asset('images/ABOUT.png') }}" class="img-fluid" alt="About Image" />
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <div class="tab-pane fade show active">
                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>Objektivitas dalam Seleksi</h4>
                                </div>
                                <p>
                                    Dengan menggunakan SPK metode AHP dan SAW ini, kriteria dan bobot dapat
                                    ditentukan secara jelas dan dapat diterapkan pada pilihan-pilihan kayu untuk produksi salah satu
                                    kerajinan meubel.
                                </p>

                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check2"></i>
                                    <h4>Efisiensi dan Waktu</h4>
                                </div>
                                <p>
                                    Penggunaan website untuk pemilihan kayu berkualitas terbaik dengan
                                    menggunakan SPK dapat meningkatkan efisiensi dan menghemat
                                    waktu.
                                </p>

                                <div class="d-flex align-items-center mt-4">
                                    <i class="bi bi-check2"></i>
                                    <h4>Analisis yang Lebih Mendalam</h4>
                                </div>
                                <p>
                                    Melalui website ini, pengguna dapat mengakses dan
                                    menganalisis data kayu-kayu secara lebih mendalam.
                                </p>
                            </div>
                            <!-- End Tab 1 Content -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End About Section -->

        <!-- ======= F.A.Q Section ======= -->
        <section id="faq" class="faq">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4">
                    <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                        <div class="content px-xl-5">
                            <h3>Frequently Asked <strong>Questions</strong></h3>
                        </div>

                        <div class="accordion accordion-flush px-xl-5" id="faqlist">
                            <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-content-1">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        Apa itu Sistem Pendukung Keputusan (SPK)?
                                    </button>
                                </h3>
                                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        SPK adalah sistem komputer atau perangkat lunak yang
                                        dirancang untuk membantu pengambilan keputusan dengan
                                        menganalisis data, memodelkan masalah, dan memberikan
                                        rekomendasi atau solusi.
                                    </div>
                                </div>
                            </div>
                            <!-- # Faq item-->

                            <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-content-2">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        Bagaimana SPK bekerja?
                                    </button>
                                </h3>
                                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        SPK bekerja dengan mengumpulkan data yang relevan,
                                        menganalisisnya menggunakan metode-metode atau model yang
                                        telah ditentukan, dan menghasilkan rekomendasi berdasarkan
                                        hasil analisis.
                                    </div>
                                </div>
                            </div>
                            <!-- # Faq item-->

                            <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-content-3">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        Apa manfaat menggunakan SPK dalam pengambilan keputusan?
                                    </button>
                                </h3>
                                <div id="faq-content-3" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        Penggunaan SPK dapat membantu mengurangi ketidakpastian,
                                        meningkatkan efisiensi, meningkatkan akurasi, mendukung
                                        pengambilan keputusan berbasis data, dan memberikan
                                        panduan dalam situasi yang kompleks.
                                    </div>
                                </div>
                            </div>
                            <!-- # Faq item-->

                            <div class="accordion-item" data-aos="fade-up" data-aos-delay="500">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-content-4">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        Apakah dibutuhkan keahlian khusus untuk menggunakan SPK?
                                    </button>
                                </h3>
                                <div id="faq-content-4" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        Penggunaan SPK biasanya membutuhkan pemahaman tentang
                                        konsep dasar SPK, pemodelan masalah, analisis data, dan
                                        penggunaan perangkat lunak atau alat yang spesifik. Namun,
                                        banyak perangkat lunak SPK yang telah dirancang untuk
                                        digunakan oleh pengguna tanpa keahlian khusus.
                                    </div>
                                </div>
                            </div>
                            <!-- # Faq item-->

                            <div class="accordion-item" data-aos="fade-up" data-aos-delay="600">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-content-5">
                                        <i class="bi bi-question-circle question-icon"></i>
                                        Bagaimana mengukur keberhasilan penggunaan SPK?
                                    </button>
                                </h3>
                                <div id="faq-content-5" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                                    <div class="accordion-body">
                                        Keberhasilan penggunaan SPK dapat diukur berdasarkan
                                        akurasi atau kebenaran rekomendasi yang diberikan,
                                        kecepatan atau efisiensi dalam pengambilan keputusan,
                                        adopsi atau penerimaan oleh pengguna, dan
                                    </div>
                                </div>
                            </div>
                            <!-- # Faq item-->
                        </div>
                    </div>

                    <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img"
                        style="background-image: url('{{ asset('images/FAQ.png') }}')">
                        &nbsp;
                    </div>
                </div>
            </div>
        </section>
        <!-- End F.A.Q Section -->
    </main>
    <!-- End Main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="footer-legal text-center">
            <div class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
                <div class="d-flex flex-column align-items-center align-items-lg-start">
                    <div class="copyright">
                        &copy; Copyright <strong><span>Syaiful Anwar</span></strong>. All Rights Reserved
                    </div>
                </div>

                <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- Bootstrap Script -->
    <script src="{{ asset('frontend/libraries/bootstrap-5.2.3-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/libraries/aos/aos.js') }}"></script>
    <script src="{{ asset('frontend/libraries/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/libraries/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/libraries/swiper/swiper-bundle.min.js') }}"></script>

    <!-- js Script -->
    <script src="{{ asset('frontend/scripts/portal.js') }}"></script>
</body>

</html>
