@extends('layouts.login')

@section('title')
    Login
@endsection

@section('content')
    <!-- ======= main ======= -->
    <section class="my-login-page">
        <div class="container form-Bg">

            <div class="row justify-content-md-center">
                <div class="card-wrapper">
                    <div class="brand">
                        <img src="{{ url('images/lock.png') }}" alt="logo" />
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            {{-- login --}}
                            <h4 class="card-title text-center">Masuk</h4>
                            <form action="{{ route('login.index') }}" method="POST" class="my-login-validation"
                                novalidate="">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username atau Email</label>
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="" required autofocus placeholder="Input username or email" />
                                    <div class="invalid-feedback">Email yang dimasukkan salah</div>
                                </div>

                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="mb-3">
                                    <label for="password" class="form-label">Sandi </label>
                                    <input id="password" type="password"
                                        class="form-control  @error('password') is-invalid @enderror" name="password"
                                        label required data-eye placeholder="Input password" />
                                    <div class="invalid-feedback">Sandi yang dimasukkan salah</div>
                                </div>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="mb-3 form-check">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input" />
                                    <label for="remember" class="form-check-label" name="remember">Ingat saya</label>
                                </div>

                                <div class="m-0 d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Masuk
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="footer">Copyright &copy; {{ now()->year }} &mdash; Syaiful Anwar</div>
                </div>
            </div>
        </div>
    </section>
@endsection
